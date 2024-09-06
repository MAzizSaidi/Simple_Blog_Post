<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Taggable;
class Comments extends Model
{
    use HasFactory , SoftDeletes, Taggable ;


    protected $fillable = [
        'content', 'commentable_id', 'commentable_type', 'user_id',
    ];



    public function commentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
       return $this->morphTo();
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
