<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeDislikeRequest;
use App\Models\Blogpost;
use App\Models\Comment;
use App\Services\BaseService;

class LikeController extends Controller
{
    protected $service;

    public function __construct(BaseService $service) {
        $this->service = $service;
    }

    public function like(LikeDislikeRequest $request) {
        $model = match ($request->type) {
            'blogpost' => Blogpost::find($request->id),
            'comment' => Comment::find($request->id),
        };

        // handling the request when a like already exists
        $existing_like = $model->likes()->where('user_id', $request->user()->id)->first();
        if ($existing_like) {
            if ($existing_like->is_liked) {
                $existing_like->delete();
                return response()->json(['message' => 'Like removed', 'likeable_id' => $model->id]);
            }
            $this->dislike($request);
        }

        $this->service->createLike(
            $request,
            $model->id,
            true,
        );

        return response()->json(['message' => 'Liked successfully', 'likeable_id' => $model->id]);
    }

    public function dislike(LikeDislikeRequest $request) {
        $model = match ($request->type) {
            'blogpost' => Blogpost::find($request->id),
            'comment' => Comment::find($request->id),
        };

        // handling the request when a dislike already exists
        $existing_dislike = $model->likes()->where('user_id', $request->user()->id)->first();
        if ($existing_dislike) {
            if (!$existing_dislike->is_liked) {
                $existing_dislike->delete();
                return response()->json(['message' => 'Dislike removed', 'likeable_id' => $model->id]);
            }
            $this->like($request);
        }

        $this->service->createLike(
            $request,
            $model->id,
            false,
        );

        return response()->json(['message' => 'Disliked successfully', 'likeable_id' => $model->id]);
    }
}
