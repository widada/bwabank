<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function show()
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->first();
        
        $userDatabase = User::find($user->id);
        $userDatabase->profile_picture = $userDatabase->profile_picture ? 
            url('storage/'.$userDatabase->profile_picture) : "";
        $userDatabase->ktp = $userDatabase->ktp ? 
            url('storage/'.$userDatabase->ktp) : "";
        $userDatabase->balance = $wallet->balance;

        return response()->json($userDatabase);
    }

    public function isEmailExist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $isExist = false;
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            $isExist = true;
        }

        return response()->json(['is_email_exist' => $isExist]);
    }
}
