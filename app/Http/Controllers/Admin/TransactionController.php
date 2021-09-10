<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $relations = [
            'product',
            'paymentMethod:id,name,code,thumbnail',
            'transactionType:id,code,action',
            'user:id,name'
        ];

        $transactions = Transaction::with($relations)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('transaction', ['transactions' => $transactions]);
    }
}
