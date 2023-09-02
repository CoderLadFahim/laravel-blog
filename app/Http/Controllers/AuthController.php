<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['bail', 'required', 'email'],
            'password' => ['bail', 'required', 'string'],
        ]);

        $user = User::where('email', request('email'))->first();

        if(Hash::check(request('password'), $user?->getAuthPassword())) {
            return response()->json([
                'token' => $user->createToken(time())->plainTextToken
            ]);
        }

        return response()->json([
            'message' => "please leave"
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
