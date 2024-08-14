<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

//        Gate::define('update_post', function($user, $post) {
//            return $user->id == $post->user_id;
//        });
//
//        Gate::define('delete_post', function($user, $post) {
//            return $user->id == $post->user_id;
//        });

//          Gate::define('posts.update','App\Policies\BlogPostPolicy@update');
//          Gate::define('posts.delete','App\Policies\BlogPostPolicy@delete');
//
        Gate::before(function($user, $ability) {
            if ($user->is_admin  && in_array($ability, ['update', 'delete' , 'restore'])) {
                return true;
            }
        });
    }
}
