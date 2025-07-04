<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'remember_token',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function blogpost(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
       return $this->hasMany('App\Models\BlogPost');
    }
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Comments');
    }

    public function commentsOn(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\Models\Comments', 'commentable');
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne('App\Models\Images', 'imageable');
    }


    public function scopeMostActiveUser( Builder $query )
    {
        return $query->withCount('blogpost')->orderby('blogpost_count', 'desc');
    }

  public function scopeMostActiveUserLastMonth(Builder $query)
{
    return $query->withCount(['blogpost' => function (Builder $query) {
        return $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
    }])->having('blogpost_count', '>=', 3)
        ->orderBy('blogpost_count', 'desc');
}
    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post): Builder
    {
        return $query->whereHas('comments', function ($query) use ($post) {
            $query->where('commentable_id', '=', $post->id)
                ->where('commentable_type', '=', BlogPost::class);
        });
    }

    public function scopeIsAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', '=', true);
    }
}

