<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);

Route::resource('transaction', TransactionController::class);

Route::resource('dashboard', DashboardController::class);

Route::get('/detail_products', [ProductController::class, 'detailproductpage'])->name('detail_products');

Route::get('/history_transaction',[TransactionController::class, 'historypage'])->name('transaction.history_transaction');

Route::get('/print_transaction/{id}',[TransactionController::class, 'printpage'])->name('transaction.print_transaction');

Route::get('/history_transaction/filter',[TransactionController::class, 'filterdate'])->name('transaction.filterdate');

Route::get('/filter',[TransactionController::class, 'filterdatedashboard'])->name('dashboard.filterdate');

Route::get('/checkoutdetail', [TransactionController::class, 'dashboardcheckout']);

// Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');

// Route::get('/transaction',[TransactionController::class, 'transactionpage'])->name('transaction');

Route::post('transaction/makeTransaction/}',[TransactionController::class, 'makeTransaction'])->name('make.transaction');

// Route::post('transactions/maketransaction', 'makeTransaction')->name('make.transaction');

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
