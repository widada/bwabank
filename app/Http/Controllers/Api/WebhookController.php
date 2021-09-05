<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function update()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);
        $notif = new \Midtrans\Notification();

        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $transactionCode = $notif->order_id;
        
        DB::beginTransaction();
        
        try {
            $status = null;

            if ($transactionStatus == 'capture'){
                if (fraudStatus == 'challenge'){
                    $status = 'challenge';
                } else if (fraudStatus == 'accept'){
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement'){
                $status = 'success';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire'){
                $status = 'failed';
            } else if ($transactionStatus == 'pending'){
                $status = 'pending';
            }

            $transaction = Transaction::where('transaction_code', $transactionCode)->first();

            if ($transaction->status !== 'success') {
                $transactionAmount = $transaction->amount;
                $userId = $transaction->user_id;

                $transaction->update(['status' => $status]);

                if ($status === 'success') {
                    Wallet::where('user_id', $transaction->user_id)->increment('balance', $transactionAmount);
                }
            }

            DB::commit();
            return response()->json();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()]);
        }

    }
}
