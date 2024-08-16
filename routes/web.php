<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
//use Illuminate\Routing\Route as RoutingRoute;

// Public routes for authentication
Route::get('/', [AuthController::class, 'login'])->name('home'); 

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registerSave'])->name('register.save');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');


// Group routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Stock routes
    Route::get('stock/entry', [StockController::class, 'entry'])->name('stock.entry');
    Route::post('stock/storeEntry', [StockController::class, 'storeEntry'])->name('stock.storeEntry');
    Route::get('stock/exit', [StockController::class, 'exit'])->name('stock.exit');
    Route::post('stock/storeExit', [StockController::class, 'storeExit'])->name('stock.storeExit');

    Route::get('stock/history/entry', [StockController::class, 'indexHistoryEntry'])->name('stock.history.entry');
    Route::get('stock/history/exit', [StockController::class, 'indexHistoryExit'])->name('stock.history.exit');


    Route::get('stock', [StockController::class, 'stock'])->name('stock.stock');
    Route::get('stock/summary', [StockController::class, 'summary'])->name('stock.summary');
    Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');
    Route::get('/filterHistory', [StockController::class, 'filterHistory'])->name('filterHistory');

    // Export routes
    Route::get('/generate-pdf', [StockController::class, 'generatePDF'])->name('generate.pdf');
    Route::get('/export-excel', [StockController::class, 'exportExcel'])->name('export.excel');
    
    // Products routes
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Suppliers routes
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
    
    // Logout route
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});


// Admin routes - only accessible by admin
Route::middleware([CheckAdmin::class])->prefix('admin')->group(function () {
    Route::post('create', [AuthController::class, 'createAdmin'])->name('admin.create');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/destroy/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('suppliers/edit/{supplier}', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('suppliers/update/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/destroy/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/update/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});


// routes/web.php
Route::get('/products-by-category/{categoryId}', [StockController::class, 'getProductsByCategory']);

Route::prefix('stock')->group(function () {
    Route::get('history/entry', [StockController::class, 'indexHistoryEntry'])->name('stock.history.entry');
    Route::get('history/entry/pdf', [StockController::class, 'downloadHistoryEntryPdf'])->name('stock.history.entry.pdf');
    Route::get('history/entry/excel', [StockController::class, 'downloadHistoryEntryExcel'])->name('stock.history.entry.excel');
    
    Route::get('history/exit', [StockController::class, 'indexHistoryExit'])->name('stock.history.exit');
    Route::get('history/exit/pdf', [StockController::class, 'downloadHistoryExitPdf'])->name('stock.history.exit.pdf');
    Route::get('history/exit/excel', [StockController::class, 'downloadHistoryExitExcel'])->name('stock.history.exit.excel');
});