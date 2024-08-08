<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;

class PostsTagController extends Controller
{
    public function index(Tags $tag)
    {
        $tags = Tags::with('blogposts')->findOrFail($tag);
        return view('BlogPost.index', ['tags' => $tags]);
    }

}
