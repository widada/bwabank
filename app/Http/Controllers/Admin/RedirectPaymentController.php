<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class RedirectPaymentController extends Controller
{
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $transaction = Transaction::where('transaction_code', $orderId)->first();

        return view('payment-finish', ['transaction' => $transaction]);   
    }
}