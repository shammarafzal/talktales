<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mouthVideo extends Model
{
    protected $fillable = [
        'video',
        'books_id',
    ];

    public function book()
    {
        return $this->belongsTo(Books::class);
    }

    use HasFactory;
}
