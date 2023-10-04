<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class BaseService
{
    public function getUser(Request $request): User {
        $bearer_token = $request->bearerToken();

        $token = PersonalAccessToken::findToken($bearer_token);
        $user = $token?->tokenable;

        return $user;
    }
}

