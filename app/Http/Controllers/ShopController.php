<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('brand', 'LIKE', "%{$search}%")
                    ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        $medicines = $query->where('stock', '>', 0)->paginate(12);
        $categories = Medicine::distinct()->pluck('category');
        
        // Get cart count for authenticated user
        $cartCount = 0;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $cartCount = $cart ? $cart->item_count : 0;
        }
        
        return view('shop', compact('medicines', 'categories', 'cartCount'));
    }
    
    public function addToCart(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $medicine = Medicine::findOrFail($request->medicine_id);
        
        // Check if enough stock
        if ($medicine->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available!'
            ], 400);
        }
        
        // Get or create cart for user
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => session()->getId()]
        );
        
        // Check if item already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('medicine_id', $medicine->id)
            ->first();
        
        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $medicine->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more than available stock!'
                ], 400);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item
            CartItem::create([
                'cart_id' => $cart->id,
                'medicine_id' => $medicine->id,
                'quantity' => $request->quantity,
                'price' => $medicine->price
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Medicine added to cart!',
            'cart_count' => $cart->fresh()->item_count
        ]);
    }
    
    public function viewCart()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.medicine')->first();
        return view('cart', compact('cart'));
    }
    
    public function updateCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem = CartItem::findOrFail($request->item_id);
        $medicine = Medicine::findOrFail($cartItem->medicine_id);
        
        if ($request->quantity > $medicine->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available!'
            ], 400);
        }
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        $cart = $cartItem->cart;
        
        return response()->json([
            'success' => true,
            'message' => 'Cart updated!',
            'item_total' => $cartItem->price * $cartItem->quantity,
            'cart_total' => $cart->total,
            'cart_count' => $cart->item_count
        ]);
    }
    
    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        
        $cart = $cartItem->cart;
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
            'cart_total' => $cart->total,
            'cart_count' => $cart->item_count
        ]);
    }

    public function getCartData()
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.medicine')->first();
        
        if (!$cart) {
            return response()->json(['items' => [], 'total' => 0, 'item_count' => 0]);
        }
        
        return response()->json([
            'items' => $cart->items,
            'total' => $cart->total,
            'item_count' => $cart->item_count
        ]);
    }
}