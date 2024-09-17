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
use App\Traits\Taggable;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes, Taggable;

    protected $fillable = [
        'title',
        'content',
        'commentable_id',
        'commentable_type',
    ];

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\Models\Comments', 'commentable');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne('App\Models\Images', 'imageable');
    }

    public function scopeMostCommented(Builder $query)
    {
        $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot(): void
    {
        static::addGlobalScope(new AdminDeletes());
        static::addGlobalScope(new LatestScope);
        parent::boot();
    }
}
