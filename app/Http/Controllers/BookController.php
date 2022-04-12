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
            $books = Books::Where('title', 'like', '%' . $search . '%')->get();
            return response([
                'status' => true,
                'data' => $books,
            ]);
        } else {
            return response([
                'status' => false,
                'data' => Books::all(),
            ]);
        }
    }
}
