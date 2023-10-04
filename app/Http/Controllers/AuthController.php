<?php

namespace App\Http\Controllers;

use App\Http\Requests\Signup as SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function signup(SignupRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken(time())->plainTextToken
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['bail', 'required', 'email'],
            'password' => ['bail', 'required', 'string'],
        ]);

        $user = User::where('email', request('email'))->first();

        if(Hash::check(request('password'), $user->getAuthPassword())) {
            return [
                'token' => $user->createToken(time())->plainTextToken
            ];
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out',
        ], 201);
    }
}
