<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blogpost;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Blogpost $blog_post, Comment $comment) {
        return $blog_post
            ->comments()
            ->get()
            ->firstWhere('id', $comment->id);
    }

    public function store(Request $request) {
        $new_comment = Comment::create([
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
            'blogpost_id' => $request->input('blogpost_id'),
        ]);

        return $new_comment;
    }

    public function update(Request $request, Blogpost $blog_post, Comment $comment) {

        $comment_to_update = $this->show($blog_post, $comment);

        $comment_to_update->update([
            'body' => $request->body,
        ]);

        return $comment_to_update;
    }

    public function destroy(Blogpost $blog_post, Comment $comment) {

        $comment_to_update = $this->show($blog_post, $comment);
        $comment_to_update->delete();
        return response()->json(['msg' => 'Comment deleted']);
    }
}
