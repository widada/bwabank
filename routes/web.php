<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PaymentMethodController;

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
        Route::get('/edit/{paymentMethodId}', [PaymentMethodController::class, 'edit'])->name('admin.payment_methods.edit');
        Route::post('/update', [PaymentMethodController::class, 'update'])->name('admin.payment_methods.update');
    });
});

Route::get('/payment_success', function () {
    return view('payment-success');
});
