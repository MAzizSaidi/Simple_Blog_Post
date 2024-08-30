<?php

namespace App\Http\Controllers;

use App\Mail\CommentedPost;
use App\Models\BlogPost;
use App\Models\User;
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
public function store(BlogPost $post, Request $request): \Illuminate\Http\RedirectResponse
{
    // Debugging statement to check the input
    dump($request->input('blog_post_id')); // dump result is 10

    // Create the comment with the correct blog post ID from the request input
    $comment = $post->comments()->create([
        'content' => $request->input('content'),
//        'commentable_id' => $request->input('blog_post_id'), // Get the blog post ID from the request input
//        'commentable_type' => BlogPost::class,
        'user_id' => Auth::id(),
    ]);



    // Debugging statements to check the values after saving
    dump($comment->commentable_id); // Should now be set correctly
    dump($comment->commentable_type); // Should be BlogPost::class
 
    // Check if the post has a user and send an email
    if ($post->user) {
        Mail::to($post->user)->send(
            new CommentedPost($comment)
        );
    }

    // Flash a status message and redirect
    session()->flash('status', 'Your comment is under review ... wait for the admin approval');
    return redirect()->route('posts.show', ['post' => $comment->commentable_id]);
}    /**
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
