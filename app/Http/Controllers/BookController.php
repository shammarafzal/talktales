<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function fetchBooks()
    {
        $books = Books::with('child_videos', 'mouth_videos')->get();
        return response()->json($books);
    }
}
