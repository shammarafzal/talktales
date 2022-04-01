<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Books;
use App\Models\ChildVideo;
use App\Models\mouthVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.index');
    }

    public function fetchBooks()
    {
        $books = Books::all();
        return response()->json([
            'status' => true,
            'books' => $books,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'storyText' => 'required',
            'image' => 'required|max:3096',
            'childVideo' => 'required',
            'mouthVideo' => 'required',
        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }

        $book = Books::create($request->all());
        $this->storeImage($book);
        foreach ($request->childVideo as $childVideo){
            $video = time().'.'.$childVideo->extension();
            ChildVideo::create([
                'book_id' => $book->id,
                'video' => $childVideo->store('childVideos', 'public'),
            ]);
        }

        foreach ($request->mouthVideo as $mouthVideo){
            $video = time().'.'.$mouthVideo->extension();
            mouthVideo::create([
                'book_id' => $book->id,
                'video' => $mouthVideo->store('mouthVideos', 'public'),
            ]);
        }
        if ($book) {
            return response()->json(['status' => 1, 'message' => 'Book added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Books $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($book)
    {
        $book = Books::find($book);
        if ($book) {
            return response()->json([
                'status' => 200,
                'book' => $book,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Book not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'childText' => 'required',

        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        $book = Books::find($book);
        $book->update($request->all());
        $this->storeImage($book);
        return response()->json(['status' => 1, 'message' => 'Book updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($book)
    {
        $book = Books::find($book);
        if (!$book) {
            return response()->json([
                'status' => 0,
                'message' => 'Book not exist',
            ]);
        }
        // $book->bookings()->delete();
        $book->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Book Deleted Successfully',
        ]);
    }

    public function storeImage($book)
    {
        $book->update([
            'image' => $this->imagePath('image', 'book', $book),
        ]);
    }

}
