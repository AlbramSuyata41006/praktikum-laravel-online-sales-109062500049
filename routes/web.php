<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route sementara agar tampilan navigasi tidak error di M1
Route::get('/', function () {
    return view('layouts.app')->with('content', 'Halaman Katalog Produk (Akan dibangun di M4)');
})->name('shop.index');
Route::get('/keranjang', function () { return 'Halaman Keranjang'; })->middleware(['auth', 'role:customer'])->name('cart.index');
Route::get('/pesanan', function () { return 'Halaman Pesanan'; })->middleware(['auth', 'role:customer'])->name('orders.index');
Route::get('/admin', function () { return 'Dashboard Admin'; })->middleware(['auth', 'role:admin'])->name('admin.dashboard');

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// Group Route untuk Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Route dummy agar tidak error saat navigasi di M2
    Route::get('/', fn () => redirect()->route('admin.products.index'))->name('dashboard');
    Route::get('/stock', function () { return 'Halaman Stok (M3)'; })->name('stock.index');
    Route::get('/shipping', function () { return 'Halaman Ekspedisi (M3)'; })->name('shipping.index');
    Route::get('/orders', function () { return 'Halaman Transaksi (M7)'; })->name('orders.index');

    // Route Master Data Kategori dan Produk
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::resource('products', AdminProductController::class)->except('show');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
