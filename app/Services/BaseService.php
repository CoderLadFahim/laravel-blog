<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class BaseService
{
    public function getUser(Request $request): User {
        $auth_header_value = $request->header('Authorization');
        [,$bearer_token] = explode(' ', $auth_header_value);

        $token = PersonalAccessToken::findToken($bearer_token);
        $user = $token?->tokenable;

        return $user;
    }

    public function getBeans(): string {
        return 'beans';
    }
}

