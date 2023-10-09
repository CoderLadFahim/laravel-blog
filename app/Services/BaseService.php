<?php


namespace App\Services;

use App\Models\Like;
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

    public function createLike(int $likeable_id, string $model_type, bool $is_liked, int $user_id) {
        Like::create([
            'likeable_id' => $likeable_id,
            'likeable_type' => match ($model_type) {
                'blogpost' => Blogpost::class,
                'comment' => Comment::class,
            },
            'is_liked' => $is_liked ? 1 : 0,
            'user_id' => $user_id,
        ]);
    }
}

