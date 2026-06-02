<?php

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\InvoiceController;
use App\Http\Controllers\Customer\PurchaseController;
use App\Http\Controllers\Manager\CustomerController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\FuelSaleController;
use App\Http\Controllers\Manager\FuelTypeController;
use App\Http\Controllers\Manager\ReportController;
use App\Http\Controllers\Manager\StockMovementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/dashboard', function () {
    return auth()->user()->isManager()
        ? redirect()->route('manager.dashboard')
        : redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin,manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', ManagerDashboardController::class)->name('dashboard');
    Route::resource('fuel-types', FuelTypeController::class);
    Route::resource('stock', StockMovementController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('sales', FuelSaleController::class)->parameters(['sales' => 'sale']);
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/{format}', [ReportController::class, 'export'])->whereIn('format', ['pdf', 'csv', 'excel'])->name('reports.export');
});

Route::middleware(['auth', 'role:customer,admin,manager'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', CustomerDashboardController::class)->name('dashboard');
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('/invoices/{sale}', [InvoiceController::class, 'download'])->name('invoices.download');
});

require __DIR__.'/auth.php';
