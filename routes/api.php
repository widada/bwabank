<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\PaymentMethodController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('webhooks', [WebhookController::class, 'update']);

Route::group(['middleware' => 'jwt.verify'], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('users', [UserController::class, 'show']);

    Route::put('wallets', [WalletController::class, 'update']);
    Route::get('wallets', [WalletController::class, 'show']);

    Route::post('top_ups', [TopUpController::class, 'store']);

    Route::get('payment_methods', [PaymentMethodController::class, 'index']);
});