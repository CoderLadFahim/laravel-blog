<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blogpost;
use Illuminate\Http\Request;

class BlogpostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Blogpost::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_blog_post = Blogpost::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
            'category_id' => $request->input('category_id'),
        ]);

        $tagIds = array_map('intval', $request->input('tags'));
        $new_blog_post->tags()->attach($tagIds);

        return $new_blog_post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blogpost $blog_post)
    {
        return $blog_post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blogpost $blog_post)
    {
        $blog_post->update([
            'name' => $request->name,
        ]);

        return $blog_post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blogpost $blog_post)
    {
        $blog_post->delete();
        return response()->json(['msg' => 'Blog post deleted']);
    }

    public function getComments(Blogpost $blog_post)
    {
        return $blog_post->comments()->get();
    }

    public function getAuthor(Blogpost $blog_post)
    {
        return $blog_post->author()->get();
    }

    public function getTags(Blogpost $blog_post)
    {
        return $blog_post->tags()->get();
    }

    public function getCategory(Blogpost $blog_post)
    {
        return $blog_post->category()->get();
    }
}
