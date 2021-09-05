<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\Wallet;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    private $paymentMethod;

    public function __construct()
    {
        $this->paymentMethod = PaymentMethod::where('code', 'bwa')->first();
    }

    public function store(Request $request)
    {
        $data = $request->only('amount', 'pin', 'username');
            
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:10000',
            'pin' => 'required|digits:6',
            'username' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $userTransfer = auth()->user();
        $paymentMethod = PaymentMethod::where('code', 'bwa')->first();
        $userReceive = User::where('username', $request->username)->first();
        
        $pinChecker = pinChecker($request->pin);
        if (!$pinChecker) {
            return response()->json(['message' => 'Your PIN is wrong'], 400);
        }
        
        if (!$userReceive) {
            return response()->json(['message' => 'Username Not Found'], 404);
        }

        $userTransferWallet = Wallet::where('user_id', $userTransfer->id)->first();
        echo $userTransferWallet->balance;
        if ($userTransferWallet->balance < $request->amount) {
            return response()->json(['message' => 'Your Balance is Not Enough'], 400);
        }


        DB::beginTransaction();
        try {
            $transactionType = TransactionType::whereIn('code', ['receive', 'transfer'])
                                                ->orderBy('code', 'asc')
                                                ->get();

            $receiveTransactionType = $transactionType->first();
            $transferTransactionType = $transactionType->last();

            // Create transaction for transfer
            $transferTransaction = $this->createTransaction([
                'user_id' => $userTransfer->id,
                'transaction_type_id' => $transferTransactionType->id,
                'description' => 'Transfer funds to '.$userReceive->username,
                'amount' => $request->amount
            ]);

            $userTransferWallet->decrement('balance', $request->amount);

            // craete transaction for receive
            $receiveTransaction = $this->createTransaction([
                'user_id' => $userReceive->id,
                'transaction_type_id' => $receiveTransactionType->id,
                'description' => 'Receive funds from '.$userReceive->username,
                'amount' => $request->amount
            ]);

            Wallet::where('user_id', $userReceive->id)->increment('balance', $request->amount);

            DB::commit();
            return response(['message' => 'Transfer Success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    private function createTransaction($params)
    {        
        $transaction = Transaction::create([
            'user_id' => $params['user_id'],
            'transaction_type_id' => $params['transaction_type_id'],
            'payment_method_id' => $this->paymentMethod->id,
            'amount' => $params['amount'],
            'transaction_code' => strtoupper(Str::random(10)),
            'description' => $params['description'],
            'status' => 'success',
        ]);

        return $transaction;
    }
}
