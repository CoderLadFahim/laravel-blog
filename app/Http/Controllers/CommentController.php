<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blogpost;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show(Request $request, Blogpost $blog_post, Comment $comment) {
        return $blog_post;
    }
}
