<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function blogposts(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany('App\Models\BlogPost', 'taggable')->withTimestamps();
    }
    public function Comments(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany('App\Models\Comments', 'taggable')->withTimestamps();
    }
}
