<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request){
        try {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->save();
            
            return response()->json([
                'message' => 'User registered successfully',
                'user' => [
                    'name' => $user->first_name,
                    'surname' => $user->last_name,
                    'email' => $user->email, 
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
        
        // Check email and password
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user(); 
            $token = auth('api')->login($user);    
            return response()->json([
                'message' => 'Login successfully',
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL()." minute",
            ]);
        } else {
            return response()->json(['error' => 'Email address or password incorrect'], 401);
        }
    }

    public function logout(){
        try {
            // Token check
            if (auth('api')->check()) {
                auth()->logout(true);
                Auth::logout();
                return response()->json(['message' => 'Successfully logged out']);
            } else {
                return response()->json(['error' => 'Invalid token'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error token verification'], 500);
        }
    }
}