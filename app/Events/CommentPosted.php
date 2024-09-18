<?php

namespace App\Events;

use App\Models\Comments;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CommentPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Comments $comment;
    /**
     * Create a new event instance.
     */
    public function __construct(Comments $comment)
    {
        $this->comment = $comment;
        Log::info('CommentPosted event fired for comment ID: ' . $comment->id);
    }


}
