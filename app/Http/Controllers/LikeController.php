<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Comment;
use App\Models\Like;
use App\Services\BaseService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    protected $service;

    public function __construct(BaseService $service) {
        $this->service = $service;
    }

    public function create(Request $request) {
        $request->validate([
            'id' => 'bail|string|required',
            'type' => 'bail|string|required',
        ]);

        $user = $this->service->getUser($request);

        $model = $request->type === 'blogpost' ? Blogpost::find($request->id) : Comment::find($request->id);

        // handling the request when a like already exists
        $existing_like_collection = $model->likes()->where('user_id', $user->id)->get();
        if (sizeof($existing_like_collection)) {
            [$existing_like] = $existing_like_collection;
            $existing_like->update([
                'is_liked' => $existing_like->is_liked ? 0 : 1
            ]);
            return response()->json(['message' => !$existing_like->is_liked ? 'Disliked successfully' : 'Liked successfully', 'likeable_id' => $model->id]);
        }

        Like::create([
            'likeable_id' => $model->id,
            'likeable_type' => $request->type === 'blogpost' ? Blogpost::class : Comment::class,
            'is_liked' => 1,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Liked successfully', 'likeable_id' => $model->id]);
    }
}
