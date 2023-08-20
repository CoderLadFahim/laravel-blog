<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['bail', 'required', 'email'],
            'password' => ['bail', 'required', 'string'],
        ]);


        if (auth()->attempt(request()->only(['email', 'password']))) {
            dd('user is legit');
        } else {
            dd('identify yourself nigga');
        }

    }
}
