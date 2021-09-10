<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransactionController;

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

    Route::get('/transaction', [TransactionController::class, 'index'])->name('admin.transaction.index');
});

Route::get('/payment_success', function () {
    return view('payment-success');
});
