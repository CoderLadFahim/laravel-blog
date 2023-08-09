<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function store(Request $request, Blogpost $blogpost) {
        $new_comment = Comment::create([
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
            'blogpost_id' => $blogpost->id
        ]);

        return $new_comment;
    }

    public function update(Request $request, Comment $comment) {

        $comment_to_update = $this->show($comment);

        $comment_to_update->update([
            'body' => $request->body,
        ]);

        return $comment_to_update;
    }

    public function destroy(Comment $comment) {

        $comment_to_update = $this->show($comment);
        $comment_to_update->delete();
        return response()->json(['msg' => 'Comment deleted']);
    }
}
