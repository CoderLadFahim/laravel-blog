<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Blogpost;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Blogpost $blogpost) {
        return response()->json($blogpost->comments);
    }

    public function show(Comment $comment) {
        return response()->json($comment);
    }

    public function store(CommentRequest $request, Blogpost $blogpost) {
        $new_comment = Comment::create([
            'body' => $request->body,
            'user_id' => $request->user()->id,
            'blogpost_id' => $blogpost->id,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return response()->json($new_comment);
    }

    public function update(CommentRequest $request, Comment $comment) {
        if ($request->user()->id !== $comment->user_id)
            return response()->json(['message' => 'Edit your own comments!']);

        $comment->update([
            'body' => $request->body
        ]);
        return response()->json($comment);
    }

    public function destroy(Comment $comment) {
        $comment_to_update = $this->show($comment);
        $comment_to_update->delete();
        return response()->json(['msg' => 'Comment deleted']);
    }

    public function getLikes(Comment $comment)
    {
        return response()->json($comment->likes()->where('is_liked', 1)->get());
    }

    public function getDislikes(Comment $comment)
    {
        return response()->json($comment->likes()->where('is_liked', 0)->get());
    }
}
