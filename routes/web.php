<?php

use App\Http\Controllers\DebugController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Public storefront
Route::get('/', [ProductController::class, 'index'])->name('storefront');

// DEBUG ROUTE - Show users with passwords (REMOVE AFTER TESTING!)
Route::get('/debug/users', [DebugController::class, 'showUsers']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Staff panel — everything under /admin, requires login
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__.'/auth.php';