<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Pharmacist Dashboard (with security check)
Route::get('/pharmacist/dashboard', function () {
    // Only pharmacists can access this
    if (Auth::user()->user_type !== 'pharmacist') {
        abort(403, 'Unauthorized access - Pharmacist area only');
    }
    return view('pharmacist.dashboard');
})->middleware(['auth', 'verified'])->name('pharmacist.dashboard');

// Admin Dashboard (if you add admin user type)
Route::get('/admin/dashboard', function () {
    // Only admins can access this
    if (Auth::user()->user_type !== 'admin') {
        abort(403, 'Unauthorized access - Admin area only');
    }
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';