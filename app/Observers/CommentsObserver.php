<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Models\Comments;
use Illuminate\Support\Facades\Cache;

class CommentsObserver
{
    public function creating(Comments $comment)
    {
        if ($comment->commentable_type === BlogPost::class) {
            Cache::forget("blog-post-{$comment->commentable_id}");
            Cache::tags(['blog-post'])->forget("mostCommented");
        }
    }
}
