<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);

    }
    public function store(User $user,Request $request)
    {

        $user->commentsOn()->create([
            'content' => $request->input('content'),
            'user_id' => Auth::user()->id,
        ]);
//        $comment = new Comments();
//        $comment->content = $request->input('content');
//        $comment->user_id = Auth::user()->id;
//        $comment->save();

        session()->flash('status', 'Your comment is under review ... wait for the admin approval');
        return redirect()->route('posts.show', ['post'=> $user]);

    }

}
