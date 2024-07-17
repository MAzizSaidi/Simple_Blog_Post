<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public static function boot(): void
    {
        parent::boot();

        static::deleting(function (BlogPost $blogpost) {
            $blogpost->comments()->delete();
        });

        static::restoring(callback: function (BlogPost $blogpost) {
         $blogpost->comments()->restore();
        });
    }
}
