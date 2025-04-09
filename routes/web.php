<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

# Public routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('products.show');

# Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

# Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    # Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::get('/products/add', [AdminProductController::class, 'create'])->name('add.product');
    Route::post('/products/add', [AdminProductController::class, 'store'])->name('add.product.submit');
    Route::get('/products/edit/{id}', [AdminProductController::class, 'edit'])->name('edit.product');
    Route::post('/products/edit/{id}', [AdminProductController::class, 'update'])->name('update.product');
    Route::get('/products/delete/{id}', [AdminProductController::class, 'destroy'])->name('delete.product');
});
