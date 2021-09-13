<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function show()
    {
        $wallet = Wallet::where('user_id', $this->user->id)->first();
        
        $userDatabase = User::find($this->user->id);
        $userDatabase->profile_picture = $userDatabase->profile_picture ? 
            url('storage/'.$userDatabase->profile_picture) : "";
        $userDatabase->ktp = $userDatabase->ktp ? 
            url('storage/'.$userDatabase->ktp) : "";
        $userDatabase->balance = $wallet->balance;

        return response()->json($userDatabase);
    }

    public function update(Request $request)
    {

        try {
            $user = User::find($this->user->id);

            $data = $request->only('name', 'username', 'ktp', 'username', 'email', 'password');
    
            if ($request->username != $user->username) {
                $isExistUsername = User::where('username', $request->username)->exists();
                if ($isExistUsername) {
                    return response(['message' => 'Username already taken'], 409);
                }
            }
    
            if ($request->email != $user->email) {
                $isExistUsername = User::where('email', $request->email)->exists();
                if ($isExistUsername) {
                    return response(['message' => 'Email already taken'], 409);
                }
            }
    
            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }
    
            if ($request->profile_picture) {
                $profilePicture = uploadBase64Image($request->profile_picture);
                $data['profile_picture'] = $profilePicture;
                if ($user->profile_picture) {
                    Storage::delete('public/'.$user->profile_picture);
                }
            }
    
            if ($request->ktp) {
                $ktp = uploadBase64Image($request->ktp);
                $data['ktp'] = $ktp;
                if ($user->ktp) {
                    Storage::delete('public/'.$user->ktp);
                }
            }
    
            $user->update($data);
    
            return response()->json(['message' => 'Updated']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }

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
