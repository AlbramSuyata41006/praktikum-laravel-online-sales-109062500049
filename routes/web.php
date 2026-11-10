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

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
