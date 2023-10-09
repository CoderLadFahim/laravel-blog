<?php


namespace App\Services;

use App\Models\Blogpost;
use App\Models\Comment;
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

    public function createLike(Request $request, int $model_id, bool $is_liked) {
        Like::create([
            'likeable_id' => $model_id,
            'likeable_type' => match ($request->type) {
                'blogpost' => Blogpost::class,
                'comment' => Comment::class,
            },
            'is_liked' => $is_liked ? 1 : 0,
            'user_id' => $request->user()->id,
        ]);
    }
}

