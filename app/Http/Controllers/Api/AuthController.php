<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\User;
use App\Models\Wallet;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'pin' => 'required|digits:6'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $user = User::where('email', $request->email)->exists();
        
        if ($user) {
            return response()->json(['message' => 'Email already taken'], 409);
        }
        
        
        DB::beginTransaction();

        try {
            $profilePicture = null;
            if ($request->profile_picture) {
               $profilePicture = uploadBase64Image($request->profile_picture);
            }

            $ktp = null;
            if ($request->ktp) {
                $ktp = uploadBase64Image($request->ktp);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->email,
                'password' => bcrypt($request->password),
                'profile_picture' => $profilePicture,
                'ktp' => $ktp,
                'verified' => ($ktp) ? true : false
            ]);

            $cardNumber = $this->generateCardNumber(16);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'pin' => $request->pin,
                'card_number' => $cardNumber
            ]);

            DB::commit();

            $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password]);

            $userResponse = getUser($user->id);
            $userResponse->token = $token;
            $userResponse->token_expires_in = auth()->factory()->getTTL() * 60;
            $userResponse->token_type = 'bearer';

            return response()->json($userResponse);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }      
            

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        try {
            $token = JWTAuth::attempt($credentials);
            
            if (!$token) {
                return response()->json(['message' => 'Login credentials are invalid'], 400);
            }

            $userResponse = getUser($request->email);
            $userResponse->token = $token;
            $userResponse->token_expires_in = auth()->factory()->getTTL() * 60;
            $userResponse->token_type = 'bearer';

            return response()->json($userResponse);

        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
 	
    }

    private function generateCardNumber($length)
    {
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        $wallet = Wallet::where('card_number', $result)->exists();
        if ($wallet) {
            return $this->generateCardNumber($length);
        }
        return $result;
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Log out success']);
    }

}
