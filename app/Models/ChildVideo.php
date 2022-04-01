<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildVideo extends Model
{
    protected $fillable = [
        'video',
        'book_id',
    ];

    public function book(){
        return $this->belongsTo(Books::class);
    }
    use HasFactory;
}
