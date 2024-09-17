<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{

    public function updating(BlogPost $blogpost)
    {

        Cache::forget("blog-post-{$blogpost->id}");
    }

    public function deleting(BlogPost $blogpost)
    {
        $blogpost->comments()->delete();
        Cache::forget("blog-post-{$blogpost->id}");

    }
    public function restoring(BlogPost $blogpost)
    {
        $blogpost->comments()->restore();
    }
}
