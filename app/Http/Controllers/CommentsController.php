<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Jobs\NotifyUserPostWasCommented;
use App\Jobs\ThrottledMail;
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
//    dump($request->input('blog_post_id')); // dump result is 33

    // Create the comment with the correct blog post ID from the request input
    $comment = Comments::create([
        'content' => $request->input('content'),
        'commentable_id' => $request->input('blog_post_id'),
        'commentable_type' => BlogPost::class,
        'user_id' => Auth::id(),
    ]);
    $comment->load('commentable');
    event(new CommentPosted($comment));
//    dd('Event dispatched');

////    dd($comment->commentable->user);
//    if ($comment->commentable) {
////        dd($comment->commentable->user);
//
//
////        Mail::to($comment->commentable->user->email)->queue(
////            new CommentedPost($comment)
////      );
//
//    }
//      same as sending email but with a $delay variable to add time for sending email
//      Mail::to()->later :
//        Mail::to($comment->commentable->user->email)->later(
//            new CommentedPost($comment)
//        );

    // Flash a status message and redirect
    session()->flash('status', 'Your comment is under review ... wait for the admin approval');
    return redirect()->route('posts.show', ['post' => $comment->commentable_id]);
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
