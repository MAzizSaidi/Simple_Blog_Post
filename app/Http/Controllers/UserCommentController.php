<?php

namespace App\Http\Controllers;


use App\Models\Comments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);

    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
//        dd($request);
        $comment = new Comments();
        $comment->content = $request->input('content');
        $comment->user_id = Auth::user()->id;
        $comment->commentable_id = $request->input('user_id');
        $comment->commentable_type = User::class; // changed this to BlogPost model
        $comment->save();

        session()->flash('status', 'Your comment is under review ... wait for the admin approval');
        return redirect()->route('users.show', ['user'=> $comment->commentable_id]);

    }

}
