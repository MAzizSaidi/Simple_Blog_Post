<?php
namespace App\Traits;

use App\Models\Tags;

trait Taggable
{
    protected static function bootTaggable(): void
    {
        static::updating(function($model){
            $model->tags()->sync(static::findTagContent($model->content));
        });

        static::created(function($model){
            $model->tags()->sync(static::findTagContent($model->content));
        });
    }


    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->morphToMany('App\Models\Tags', 'taggable')->withTimestamps();
    }

    private static function findTagContent($content)
    {
        preg_match_all('/@([^@]+)@/m', $content, $matches);

        return Tags::whereIn('name',$matches[1] ?? [])->get();
    }




}

