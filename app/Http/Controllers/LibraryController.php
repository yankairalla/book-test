<?php

namespace App\Http\Controllers;

use App\Book;
use \App\Library;
use Illuminate\Http\Request;
use \App\Http\Resources\Book as bookResource;
use \App\Http\Resources\Library as libraryResource;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libraries = Library::all();

        return libraryResource::collection($libraries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $library = Library::create(['name' => $request->name]);
        return new libraryResource($library);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $library = Library::findOrFail($id);

            $books = $library->books;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Library does not exist!']);
        }

        return bookResource::collection($books);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $library = Library::findOrFail($id);
            $library->update($request->all());
            $library->save();
        } catch (\Exception $e) {
            return response()->json(['message' => "Library was not Updated!"]);
        }
        return new libraryResource($library);
    }


    public function addBook(Request $request, $id, $bookId)
    {

        try {
            $library = Library::findOrFail($id);
            $book = Book::findOrFail($bookId);
            $library->books()->attach($bookId);
            $library->save();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Book or Library not found!'], 404);
        }
        return response()->json(['message' => 'Book added to Library!']);

        // return response()->json(['message' => $test, 'book'=> $book]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $library = Library::findOrFail($id);
            $library->destroy();
        } catch (\Exception $e) {
            return response()->json(['error' => "Library wasn't  deleted or doesn't exist!"]);
        }

        return response()->json(['message' => 'Library was deleted']);
    }

    public function deleteBook($id, $bookId)
    {

        try {
            $library = Library::findOrFail($id);
            Book::findOrFail($bookId);

            $library->books()->detach($bookId);
            $library->save();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Book or library not found!']);
        }

        return response()->json(['message' => 'Book remove from Library!']);
    }
}
