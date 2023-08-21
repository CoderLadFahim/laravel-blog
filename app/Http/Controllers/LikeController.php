<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Blogpost $blogpost) {
        $new_like = Like::create([
            'blogpost_id' => $blogpost->id,
        ]);

        return response()->json($new_like);
    }
}
