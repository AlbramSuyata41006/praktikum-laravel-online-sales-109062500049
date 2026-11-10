<?php
use App\Http\Controllers\ProductCatalogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ShippingServiceController;


Route::get('/', [ProductCatalogController::class, 'index'])->name('shop.index');
Route::post('/keranjang/{product}', function () { return 'Fungsi tambah ke keranjang (M5)'; })->middleware(['auth', 'role:customer'])->name('cart.store');
Route::get('/produk/{product:slug}', [ProductCatalogController::class, 'show'])->name('shop.show');
Route::get('/keranjang', function () { return 'Halaman Keranjang'; })->middleware(['auth', 'role:customer'])->name('cart.index');
Route::get('/pesanan', function () { return 'Halaman Pesanan'; })->middleware(['auth', 'role:customer'])->name('orders.index');




// Group Route untuk Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin otomatis diarahkan ke produk (Revisi M2)
    Route::get('/', fn () => redirect()->route('admin.products.index'))->name('dashboard');

    // Route dummy untuk M7 (Dibiarkan saja)
    Route::get('/orders', function () { return 'Halaman Transaksi (M7)'; })->name('orders.index');


    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');


    Route::get('/shipping', [ShippingServiceController::class, 'index'])->name('shipping.index');
    Route::post('/shipping', [ShippingServiceController::class, 'store'])->name('shipping.store');
    Route::put('/shipping/{shippingService}', [ShippingServiceController::class, 'update'])->name('shipping.update');
    Route::delete('/shipping/{shippingService}', [ShippingServiceController::class, 'destroy'])->name('shipping.destroy');


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

