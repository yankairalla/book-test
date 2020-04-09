<?php

namespace App\Http\Controllers;

use \App\Category;
use \App\Http\Resources\Book as bookResource;
use \App\Http\Resources\Category as categoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return categoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $category = new Category;
            $category->name = $request->input('name');
            $category->save();
        } catch(\Exception $e) {
            return response()->json(['message' => 'Category not created']);
        }

        return new categoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $books = Category::findOrFail($id)->books;

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
            $category = Category::findOrFail($id);
            $category->name = $request->input('name');
            $category->save();
        } catch(\Exception $e) {
            return response()->json(['message' => 'Category not updated']);
        }

        return new categoryResource($category);
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
            $category = Category::findOrFail($id);
            $category->delete();
        } catch(\Exception $e) {
            return response()->json(['message'=> 'Category not found!']);
        }

        return response()->json(['message'=> 'Category deleted!']);
    }
}
