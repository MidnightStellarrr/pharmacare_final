<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('pharmacist.dashboard', compact('medicines'));
    }

    public function create()
    {
        return view('pharmacist.add_medicine');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'reorder_level' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Add image validation
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
            $validated['image'] = $imagePath;
        }

        $medicine = Medicine::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Medicine added successfully!',
                'medicine' => $medicine
            ]);
        }

        return redirect()->route('pharmacist.medicines.index')
            ->with('success', 'Medicine added successfully!');
    }

    public function edit(Medicine $medicine)
    {
        return view('pharmacist.edit_medicine', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'reorder_level' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $imagePath = $request->file('image')->store('medicines', 'public');
            $validated['image'] = $imagePath;
        }

        $medicine->update($validated);

        return redirect()->route('pharmacist.medicines.index')
            ->with('success', 'Medicine updated successfully!');
    }

    public function destroy(Medicine $medicine)
    {
        // Delete image file
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }
        
        $medicine->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Medicine deleted successfully!'
            ]);
        }

        return redirect()->route('pharmacist.medicines.index')
            ->with('success', 'Medicine deleted successfully!');
    }

    public function getInventoryData()
    {
        $medicines = Medicine::all();
        
        $totalStockValue = $medicines->sum(function($medicine) {
            return $medicine->stock * $medicine->price;
        });
        
        $lowStockItems = $medicines->filter(function($medicine) {
            return $medicine->isLowStock();
        })->count();
        
        $nearExpiryItems = $medicines->filter(function($medicine) {
            return $medicine->isNearExpiry();
        })->count();
        
        $todaySales = 5420;
        
        return response()->json([
            'medicines' => $medicines,
            'stats' => [
                'total_stock_value' => $totalStockValue,
                'low_stock_alerts' => $lowStockItems,
                'near_expiry' => $nearExpiryItems,
                'today_sales' => $todaySales
            ]
        ]);
    }
}