<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book_images extends Model
{
    protected $fillable = [
        'image',
        'book_id',
    ];

    public function book()
    {
        return $this->belongsTo(Books::class);
    }
    use HasFactory;
}
