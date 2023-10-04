<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Like;
use App\Services\BaseService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    protected $service;

    public function __construct(BaseService $service) {
        $this->service = $service;
    }

    public function create(Request $request, Blogpost $blogpost) {
        $user = $this->service->getUser($request);

        $existing_like_collection = $blogpost->likes()->where('user_id', $user->id)->get();
        if (sizeof($existing_like_collection)) {
            [$existing_like] = $existing_like_collection;
            $existing_like->update([
                'is_liked' => $existing_like->is_liked ? 0 : 1
            ]);
            return response()->json(['message' => !$existing_like->is_liked ? 'blogpost disliked successfully' : 'blogpost liked successfully', 'post_id' => $blogpost->id]);
        }

        $new_like = Like::create([
            'likeable_id' => $blogpost->id,
            'likeable_type' => Blogpost::class, // subject to change
            'is_liked' => 1,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'blogpost liked successfully', 'post_id' => $blogpost->id]);
    }
}
