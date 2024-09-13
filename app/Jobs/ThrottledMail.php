<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ThrottledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $mail;
    /**
     * Create a new job instance.
     */
    public function __construct(Mailable $mail , User $user, )
    {
        $this->mail = $mail;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Redis::throttle("mailtrap") // Rate limiter key
        ->allow(5) // No. executions permitted
        ->every(10) // Time range in seconds
        ->then(function () {

            // Lock acquired.
            Mail::to($this->user->email)->send($this->mail);

        }, function () {

            // Lock not acquired.
            return $this->release(5);
        });
    }
}
