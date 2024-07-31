<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
class  BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::withCount('comments')->with('user')->get();

        $mostCommented = Cache::remember('mostCommented', now()->addSeconds(20) , function () {
           return BlogPost::MostCommented()->take(5)->get();
        });
        $activeUser = Cache::remember('activeUser', now()->addSeconds(20) , function () {
            return User::MostActiveUser()->take(5)->get();
        });
        $MostActiveUserLastMonth = Cache::remember('MostActiveUserLastMonth', now()->addSeconds(20) , function () {
            return User::MostActiveUserLastMonth()->take(5)->get();
        });

        return view(
            'BlogPost.fetch',
            [
                'posts' => $posts,
                'mostCommented' => $mostCommented,
                'activeUser' => $activeUser,
                'MostActiveUserLastMonth' => $MostActiveUserLastMonth,
            ]

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
        $request->session()->flash('status', 'The resource was created successfully');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $post)
    {
        $post = Cache::remember("blog-post-{$post->id}" , now()->addSeconds(20) , function() use ($post) {
          return  BlogPost::with('comments')->findOrFail($post->id);
        });
        return view('BlogPost.index',
            ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $post)
    {
        if(Gate::denies('update',$post)){
            abort(403,'you don\'t have permission to update this resource');
        };

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
        $request->session()->flash('status', 'The resource was updated successfully');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy( Request $request , BlogPost $post)
    {
        $this->authorize($post);
        $post->delete();
        $request->session()->flash('danger', 'The resource was deleted successfully');
        return redirect()->route('posts.index');
    }
    public function restore(Request $request, BlogPost $post)
    {
        $post = BlogPost::onlyTrashed()->find($post->id);
        $post->restore();
        $request->session()->flash('success', 'The resource was restored successfully');
        return redirect()->route('posts.show' , ['post' => $post->id]);
    }
}
