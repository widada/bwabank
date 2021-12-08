<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\TransactionTypeController;
use App\Http\Controllers\Admin\TipController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RedirectPaymentController;

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
    
    Route::get('login', [AuthController::class, 'index'])->name('admin.auth.index');
    Route::post('login', [AuthController::class, 'login'])->name('admin.auth.login');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.auth.logout');
    
    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('admin.dashboard');
    
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
    
        Route::group(['prefix' => 'tips'], function () {
            Route::get('/', [TipController::class, 'index'])->name('admin.tips.index');
            Route::get('/create', [TipController::class, 'create'])->name('admin.tips.create');
            Route::post('/store', [TipController::class, 'store'])->name('admin.tips.store');
            Route::get('/edit/{id}', [TipController::class, 'edit'])->name('admin.tips.edit');
            Route::put('/update/{id}', [TipController::class, 'update'])->name('admin.tips.update');
            Route::delete('/destroy/{id}', [TipController::class, 'destroy'])->name('admin.tips.destroy');
        });
    });
});

Route::get('/payment_finish', [RedirectPaymentController::class, 'finish']);
