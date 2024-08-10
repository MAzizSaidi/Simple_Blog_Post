<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Images extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'blogpost_id',
    ];

    public function blogpost()
    {
        return $this->belongsTo('App\Models\Images');
    }

}
