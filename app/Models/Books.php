<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'storyText',
        'image',
    ];

    public function childVideos(){
        return $this->hasMany(ChildVideo::class);
    }

    public function mouthVideos(){
        return $this->hasMany(mouthVideo::class);
    }

}
