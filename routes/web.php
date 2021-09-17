<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\TransactionTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::get('/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');

    Route::group(['prefix' => 'payment_methods'], function () {
        Route::get('/', [PaymentMethodController::class, 'index'])->name('admin.payment_methods.index');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('admin.payment_methods.create');
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('admin.payment_methods.store');
        Route::get('/edit/{id}', [PaymentMethodController::class, 'edit'])->name('admin.payment_methods.edit');
        Route::put('/update/{id}', [PaymentMethodController::class, 'update'])->name('admin.payment_methods.update');
        Route::delete('/destroy/{id}', [PaymentMethodController::class, 'destroy'])->name('admin.payment_methods.destroy');
    });

    Route::group(['prefix' => 'transaction_types'], function () {
        Route::get('/', [TransactionTypeController::class, 'index'])->name('admin.transaction_types.index');
        Route::get('/create', [TransactionTypeController::class, 'create'])->name('admin.transaction_types.create');
        Route::post('/store', [TransactionTypeController::class, 'store'])->name('admin.transaction_types.store');
        Route::get('/edit/{id}', [TransactionTypeController::class, 'edit'])->name('admin.transaction_types.edit');
        Route::put('/update/{id}', [TransactionTypeController::class, 'update'])->name('admin.transaction_types.update');
        Route::delete('/destroy/{id}', [TransactionTypeController::class, 'destroy'])->name('admin.transaction_types.destroy');
    });
});

Route::get('/payment_success', function () {
    return view('payment-success');
});
