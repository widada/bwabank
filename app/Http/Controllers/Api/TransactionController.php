<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Request $request)
    {

        $limit = $request->query('limit') !== null ? $request->query('limit') : 10;

        $relations = [
            'product',
            'paymentMethod:id,name,code,thumbnail',
            'transactionType:id,name,code,action,thumbnail'
        ];

        $user = auth()->user();

        $transactions = Transaction::with($relations)
                                    ->where('user_id', $user->id)
                                    ->where('status', 'success')
                                    ->orderBy('id', 'desc')
                                    ->paginate($limit);

        return response()->json($transactions);
    }
}
