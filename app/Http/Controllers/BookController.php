<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function fetchBooks()
    {
        $books = Books::with('childVideos', 'mouthVideos')->get();
        return response()->json($books);
    }
    public function search(Request $request)
    {
        if ($request->search) {
            $search = $request->input('search');
            $books = Books::with('childVideos', 'mouthVideos')->where('title', 'like', '%' . $search . '%')->get();
            return response()->json($books);
        } else {
            return response()->json(
                Books::all(),
            );
        }
    }
}
