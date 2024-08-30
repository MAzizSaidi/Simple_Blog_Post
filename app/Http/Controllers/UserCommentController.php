<?php

namespace App\Http\Controllers;


use App\Mail\CommentedPost;
use App\Models\Comments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);

    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
{
    $comment = Comments::create([
        'content' => $request->input('content'),
        'user_id' => Auth::id(),
        'commentable_id' => $request->input('user_id'),
        'commentable_type' => User::class,
    ]);

//    dd($comment->toArray(), $comment->commentable);
    // Check if commentable is not null before sending the email
    $comment->load('commentable');
    if ($comment->commentable) {
        Mail::to($comment->commentable->email)->send(
            new CommentedPost($comment)
        );
    } else {
        // Handle the case where commentable is null
        session()->flash('error', 'Unable to send email. Commentable is null.');
    }

    session()->flash('status', 'Your comment is under review ... wait for the admin approval');
    return redirect()->route('users.show', ['user' => $comment->commentable_id]);
}

}
