<?php

namespace App\Jobs;

use App\Mail\NotifyUserWhenCommentedOnPost;
use App\Models\Comments;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Comments $comment;

    /**
     * Create a new job instance.
     */
    public function __construct(Comments $comment)
    {
        $this->comment = $comment;
        Log::info('NotifyUserPostWasCommented job instance created.');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('NotifyUserPostWasCommented job started.', ['comment_id' => $this->comment->id]);

        User::ThatHasCommentedOnPost($this->comment->commentable)
            ->get()
            ->filter(fn(User $user) => $user->id !== $this->comment->user_id)
            ->map(function (User $user) {
                Log::info('Sending email to user.', ['user_id' => $user->id, 'email' => $user->email]);
                Mail::to($user->email)->send(
                    new NotifyUserWhenCommentedOnPost($this->comment)
                );
            });

        Log::info('NotifyUserPostWasCommented job completed.');
    }
}
