<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->only('pin'), [
            'pin' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $user = auth()->user();

        Wallet::where('user_id', $user->id)
            ->update(['pin' => bcrypt($request->pin)]);

        return response()->json(['message' => 'Pin updated']);
    }

    public function show()
    {
        $user = auth()->user();

        $wallet = Wallet::select('balance')->where('user_id', $user->id)->first();

        return response()->json($wallet);
    }
}
