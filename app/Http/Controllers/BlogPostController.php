<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Images;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class  BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::withCount('comments')->with(['user','tags'])->get();

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
        // image handling need to be optimized cuz i'm adding extra methoud assests() to $post->image-path
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');

            $filePath = $file->storeAs('thumbnails', $post->id . '.' . $file->guessExtension());
            $fileUrl = Storage::disk('local')->url($filePath);


            $post->images()->create(['path' => $fileUrl]);
        }

        $request->session()->flash('status', 'The resource was created successfully');
        return redirect()->route('posts.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(BlogPost $post)
    {
        $sessionId = session()->getId();
        $postId = $post->id;
        $counterKey = "blog-post{$postId}-counter";
        $usersKey = "blog-post{$postId}-user";
        $users = Cache::get($usersKey, []);
        $now = now();
        $usersUpdate = [];
        $difference = 0;

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) < 1) {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >= 1) {
            $difference++;
            $usersUpdate[$sessionId] = $now;
        }

        Cache::forever($usersKey, $usersUpdate);

        if ($difference != 0) {
            if (!Cache::has($counterKey)) {
                Cache::forever($counterKey, 1);
            } else {
                Cache::increment($counterKey, $difference);
            }
        }

        $counter = Cache::get($counterKey);


        $post = Cache::remember("blog-post-{$post->id}" , now()->addSeconds(20) , function() use ($post) {
          return  BlogPost::with(['comments.user','tags','user'])->findOrFail($post->id);
        });

        return view('BlogPost.index',
            [
                'post' => $post,
                'conter' => $counter,
            ]);

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
