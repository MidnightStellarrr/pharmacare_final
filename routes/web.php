<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pharmacist\MedicineController;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';