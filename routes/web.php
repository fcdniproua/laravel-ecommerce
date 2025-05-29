<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Shop\ProductCatalog;
use App\Livewire\Shop\Cart;
use App\Livewire\Shop\Checkout;
use App\Livewire\Shop\OrderSuccess;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\OrderList;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', ProductCatalog::class)->name('home');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/orders/{order}/success', OrderSuccess::class)->name('order.success');

// Dashboard & Profile
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', \App\Livewire\Profile\Edit::class)->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Cart operations
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Order operations
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])
    ->middleware(['auth'])
    ->name('orders.show');

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.products');
    })->name('admin.dashboard');

    Route::get('/products', ProductList::class)->name('admin.products');
    Route::get('/orders', OrderList::class)->name('admin.orders');
});

// Auth routes
require __DIR__.'/auth.php';
