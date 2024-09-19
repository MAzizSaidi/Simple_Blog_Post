<?php

namespace App\Listeners;

use App\Events\BlogPostPosted;
use App\Jobs\ThrottledMail;
use App\Mail\BlogPostAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminBlogPostCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BlogPostPosted $event): void
    {
    User::IsAdmin()->get()->map(
        function (User $user) {
            ThrottledMail::dispatch( new BlogPostAdded(), $user);
        }
    );
    }
}
