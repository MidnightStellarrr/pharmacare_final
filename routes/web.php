<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pharmacist\MedicineController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth; // ADD THIS LINE


Route::get('/', function () {
    return view('welcome');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/contact', function () {
    return view('contact');
}); 

Route::get('/cart', function () {
    return view('cart');
}); 

Route::get('/shop', function () {
    return view('shop');
}); 

// Customer Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Pharmacist Dashboard (no security check)
Route::get('/pharmacist/dashboard', function () {
    return view('pharmacist.dashboard');
})->middleware(['auth', 'verified'])->name('pharmacist.dashboard');

// All Pharmacist Medicine Routes (no security check)
Route::middleware(['auth', 'verified'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::resource('medicines', MedicineController::class);
    Route::get('inventory-data', [MedicineController::class, 'getInventoryData'])->name('inventory.data');
});

// Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/cart', [ShopController::class, 'viewCart'])->name('cart.view');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Add this anywhere before the require __DIR__.'/auth.php'; line
Route::get('/check-login', function() {
    return response()->json(['logged_in' => Auth::check()]);
})->name('check.login');

Route::get('/api/cart-data', [ShopController::class, 'getCartData'])->middleware(['auth'])->name('api.cart.data');

require __DIR__.'/auth.php';