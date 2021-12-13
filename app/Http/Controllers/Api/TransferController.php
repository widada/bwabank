<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransferHistory;
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

    private $transactionCode;

    public function __construct()
    {
        $this->paymentMethod = PaymentMethod::where('code', 'bwa')->first();

        $this->transactionCode = strtoupper(Str::random(10));
    }

    public function store(Request $request)
    {
        $data = $request->only('amount', 'pin', 'send_to');
            
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:1000',
            'pin' => 'required|digits:6',
            'send_to' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $sender = auth()->user();
        $paymentMethod = PaymentMethod::where('code', 'bwa')->first();
        $receiver = User::select('users.id', 'users.username')
                            ->join('wallets', 'wallets.user_id', 'users.id')
                            ->where('users.username', $request->send_to)
                            ->orWhere('wallets.card_number', $request->send_to)
                            ->first();

        $pinChecker = pinChecker($request->pin);
        if (!$pinChecker) {
            return response()->json(['message' => 'Your PIN is wrong'], 400);
        }
        
        if (!$receiver) {
            return response()->json(['message' => 'User receiver not found'], 404);
        }

        if ($sender->id == $receiver->id) {
            return response()->json(['message' => 'You can\'t transfer to yourself'], 400);
        }

        $senderWallet = Wallet::where('user_id', $sender->id)->first();
        
        if ($senderWallet->balance < $request->amount) {
            return response()->json(['message' => 'Your balance is not enough'], 400);
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
                'user_id' => $sender->id,
                'transaction_type_id' => $transferTransactionType->id,
                'description' => 'Transfer funds to '.$receiver->username,
                'amount' => $request->amount
            ]);

            $senderWallet->decrement('balance', $request->amount);

            // craete transaction for receive
            $receiveTransaction = $this->createTransaction([
                'user_id' => $receiver->id,
                'transaction_type_id' => $receiveTransactionType->id,
                'description' => 'Receive funds from '.$sender->username,
                'amount' => $request->amount
            ]);

            Wallet::where('user_id', $receiver->id)->increment('balance', $request->amount);

            TransferHistory::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'transaction_code' => $this->transactionCode
            ]);

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
            'transaction_code' => $this->transactionCode,
            'description' => $params['description'],
            'status' => 'success',
        ]);

        return $transaction;
    }
}
