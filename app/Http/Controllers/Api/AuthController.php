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
            'username' => 'required',
            'password' => 'required|string|min:6',
            'pin' => 'required|digits:6'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $user = User::where('email', $request->email)
                    ->orWhere('username', $request->username)
                    ->first();
        
        if ($user && $user->username == $request->username) {
            return response()->json(['message' => 'Username already taken'], 409);
        }

        if ($user && $user->email == $request->email) {
            return response()->json(['message' => 'Email already exist'], 409);
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
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'profile_picture' => $profilePicture,
                'ktp' => $ktp
            ]);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'pin' => bcrypt($request->pin)
            ]);

            DB::commit();

            return response()->json(['message' => 'User created'], 201);
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

            return response()->json($this->respondWithToken($token));

        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
 	
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Log out success']);
    }

}
