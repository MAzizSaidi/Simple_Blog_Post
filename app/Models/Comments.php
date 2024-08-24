<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'content',

    ];

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
       return $this->morphTo();
    }
    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->morphToMany('App\Models\Tags', 'taggable')->withTimestamps();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function boot(): void
    {
        parent::boot();

//        static::addGlobalScope(new LatestScope);

    }
}
