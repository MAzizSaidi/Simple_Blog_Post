<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $posts = BlogPost::withCount('comments')->get();


        return view(
            'BlogPost.fetch',
            ['posts' => $posts] ,
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('BlogPost.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new BlogPost();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = Auth::user()->id;
        $post->save();
        $request->session()->flash('success', 'The resource was created successfully');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $post)
    {
        return view('BlogPost.index' , ['post' =>BlogPost::with('comments')->findOrFail($post->id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $post)
    {
        return view('BlogPost.update', ['post' =>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $post)
    {
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        $request->session()->flash('success', 'The resource was updated successfully');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Request $request , BlogPost $post)
    {
        $post->delete();
        $request->session()->flash('success', 'The resource was deleted successfully');
        return redirect()->route('posts.index');
    }
}
