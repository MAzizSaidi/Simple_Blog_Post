<?php

namespace App\Models;

use App\Scopes\AdminDeletes;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
    ];

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
       return $this->hasMany('App\Models\Comments');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
       return $this->belongsTo('App\Models\User');
    }

    public function scopeMostCommented( Builder $qurey)
    {
            $qurey->withcount('comments')->orderBy('comments_count' , 'desc');
    }

    public static function boot(): void
    {
        static::addGlobalScope(new AdminDeletes());

        parent::boot();

        static::addGlobalScope(new LatestScope);

        static::deleting(function (BlogPost $blogpost) {
            Cache::forget("blog-post-{$blogpost->id}");
            $blogpost->comments()->delete();
        });

        static::updating(function (BlogPost $blogpost) {
           Cache::forget("blog-post-{$blogpost->id}");
        });

        static::restoring(callback: function (BlogPost $blogpost) {
         $blogpost->comments()->restore();
        });
    }
}
