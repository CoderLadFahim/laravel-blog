<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blogpost;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogpostController extends Controller
{
    protected $service;

    public function __construct(BaseService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogposts = Blogpost::latest()->get();
        $search_term = request('search');

        if (!$search_term) return response()->json($blogposts);
        return Blogpost::latest()->search(['search_term' => $search_term])->get();
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
        $user_id_from_req = $request->user()->id;
        $blogpost_user_id = $blogpost->user()->first()->id;

        if ($user_id_from_req !== $blogpost_user_id) {
            return response()->json(['message' => 'Edit your own posts!']);
        }

        $request->validate([
            'title' => ['bail', 'required', 'max:100', 'string'],
            'body' => ['bail', 'required', 'string'],
        ]);

        $blogpost->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => (int) $request->category_id ?? $blogpost->category_id,
        ]);

        return response()->json(['message' => 'blogpost updated', 'blogpost' => $blogpost]);
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
        return response()->json($blogpost->user()->first());
    }

    public function getTags(Blogpost $blogpost)
    {
        return response()->json($blogpost->tags()->get());
    }

    public function getCategory(Blogpost $blogpost)
    {
        return response()->json($blogpost->category()->first());
    }

    public function getLikes(Blogpost $blogpost)
    {
        return response()->json($blogpost->likes()->where('is_liked', 1)->get());
    }

    public function getDislikes(Blogpost $blogpost)
    {
        return response()->json($blogpost->likes()->where('is_liked', 0)->get());
    }
}
