<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUserPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentedPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyUserAboutComment
{
    /**
     * Create the event listener.
     */

    /**
     * Handle the event.
     */
    public function handle(CommentPosted $event): void
    {
//        Log::info('Listener triggered');
//        dd('Listener triggered'); // For debugging purposes

        ThrottledMail::dispatch(new CommentedPost($event->comment),
            $event->comment->commentable->user
        );
        NotifyUserPostWasCommented::dispatch($event->comment);

    }
}
