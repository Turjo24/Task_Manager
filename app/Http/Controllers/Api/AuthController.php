<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        $token=$user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success'=>true,
            'message'=>'Registration Successful',
            'token'=>$token,
            'user'=>$user
        ],201);
    }

    public function login(LoginRequest $request)
    {
        $user=User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password))
        {
            return response()->json([
                'success'=>false,
                'message'=>'Invalid Credentials'
            ],401);
        }

        $token=$user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success'=>true,
            'message'=>'Login Successful',
            'token'=>$token,
            'user'=>$user
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success'=>true,
            'user'=>$request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Logout Successful'
        ]);
    }
}