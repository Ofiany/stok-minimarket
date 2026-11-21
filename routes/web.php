<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/registrasi', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registrasi', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('produk', ProductController::class)
        ->parameters(['produk' => 'product'])
        ->names('products');

    Route::resource('supplier', SupplierController::class)
        ->parameters(['supplier' => 'supplier'])
        ->names('suppliers');

    Route::get('purchase-order', [PurchaseOrderController::class, 'index'])->name('po.index');
    Route::get('purchase-order/buat', [PurchaseOrderController::class, 'create'])->name('po.create');
    Route::post('purchase-order', [PurchaseOrderController::class, 'store'])->name('po.store');
    Route::get('purchase-order/{po}', [PurchaseOrderController::class, 'show'])->name('po.show');
    Route::post('purchase-order/{po}/terima', [PurchaseOrderController::class, 'receive'])->name('po.receive');
    Route::post('purchase-order/{po}/batal', [PurchaseOrderController::class, 'cancel'])->name('po.cancel');

    Route::get('laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('laporan/buat', [ReportController::class, 'create'])->name('reports.create');
    Route::post('laporan', [ReportController::class, 'store'])->name('reports.store');
    Route::get('laporan/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('laporan/{report}/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
});
