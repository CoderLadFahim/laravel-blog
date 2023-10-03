<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blogpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class BlogpostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth_header_value = $request->header('Authorization');
        [,$bearer_token] = explode(' ', $auth_header_value);

        $token = PersonalAccessToken::findToken($bearer_token);
        $user_id =  $token?->tokenable?->id;

        $blogposts = Blogpost::where('user_id', $user_id)->get();
        $search_term = request('search');

        if (!$search_term) return response()->json($blogposts);
        return Blogpost::latest()->search(['search_term' => $search_term, 'user_id' => $user_id])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['bail', 'required', 'max:100', 'string'],
            'body' => ['bail', 'required', 'string'],
            'user_id' => ['bail', 'required'],
            'category_id' => ['bail', 'required'],
        ]);

        $new_blog_post = Blogpost::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
            'category_id' => $request->input('category_id'),
        ]);

        $tagIds = array_map('intval', $request->input('tags'));
        $new_blog_post->tags()->attach($tagIds);

        return response()->json($new_blog_post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blogpost $blogpost)
    {
        return response()->json($blogpost);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blogpost $blogpost)
    {
        $request->validate([
            'title' => ['bail', 'required', 'max:100', 'string'],
            'body' => ['bail', 'required', 'string'],
            'user_id' => ['bail', 'required'],
            'category_id' => ['bail', 'required'],
        ]);

        $updated_blogpost = $blogpost->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return response()->json($updated_blogpost);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blogpost $blogpost)
    {
        $blogpost->delete();
        return response()->json(['msg' => 'Blog post deleted']);
    }

    public function getComments(Blogpost $blogpost)
    {
        return response()->json($blogpost->comments()->get());
    }

    public function getAuthor(Blogpost $blogpost)
    {
        return response()->json($blogpost->author()->get());
    }

    public function getTags(Blogpost $blogpost)
    {
        return response()->json($blogpost->tags()->get());
    }

    public function getCategory(Blogpost $blogpost)
    {
        return response()->json($blogpost->category()->get());
    }

    public function getLikes(Blogpost $blogpost)
    {
        return response()->json($blogpost->likes()->get());
    }
}
