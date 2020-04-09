<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as bookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return bookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->payload();
        $validatedData = $request->validate([
            'title' => 'required', 
            'author' => 'required'
            ]);

            if($validatedData) {
                Book::insert([
                    'title' =>$request->title,
                    'author'=>$request->author, 
                    'user_id' => $user('id')
                    ]);
                return response()->json(['message'=> 'Book Created!']);
            }

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
            $book = Book::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Book not found']);
        }

        return new bookResource($book);
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
            $user = auth()->payload();
            $book = Book::findOrFail($id);

            if($book->user->id === $user('id') || $user('role') <= 1 ) {
                $bookData = $request->all();
                $book->update($bookData);
            }else {
                return response()->json(['message'=> 'Update Unauthorized']);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Book not found']);
        }

        // return response()->json(['book-user-id' => $book->user->id, 'id'=>$user('id'), 'role' => '' ]);
        return new bookResource($book);
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
            $user = auth()->payload();
            $book = Book::findOrFail($id);

            if($book->user->id === $user('id') || $user('role') <= 1 ) {
                $book->delete();
            }else {
                return response()->json(['message'=> 'Delete Unauthorized']);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Book not found']);
        }

        // return response()->json(['book-user-id' => $book->user->id, 'id'=>$user('id'), 'role' => '' ]);
        return new bookResource($book);
    }
}
