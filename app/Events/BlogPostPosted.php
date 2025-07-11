<?php

namespace App\Events;

use App\Models\BlogPost;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlogPostPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BlogPost $blogpost;

    /**
     * Create a new event instance.
     */
    public function __construct(BlogPost $blogpost)
    {
        $this->blogpost = $blogpost;
    }


}
