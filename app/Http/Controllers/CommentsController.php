<?php

namespace App\Http\Controllers;

use App\Mail\CommentedPost;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPost $post,Request $request): \Illuminate\Http\RedirectResponse
    {
        $comment = new Comments();
        $comment->content = $request->input('content');
        $comment->commentable_id = $request->input('blog_post_id');
        $comment->commentable_type = BlogPost::class; // changed this to BlogPost model
        $comment->user_id = Auth::user()->id;
        $comment->save();

        Mail::To($comment->user)->send(
            new CommentedPost($comment)
        );

        session()->flash('status', 'Your comment is under review ... wait for the admin approval');
        return redirect()->route('posts.show', ['post'=> $comment->commentable_id]);

//        handle the comments caching it won't be prtinted too'
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
