<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Comments;
use App\Observers\BlogPostObserver;
use App\Observers\CommentsObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BlogPost::observe(BlogPostObserver::class);
        Comments::observe(CommentsObserver::class);
    }
}
