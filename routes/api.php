<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth/login', 'AuthController@login');

Route::get('user', 'UserController@index');
Route::get('user/{id}', 'UserController@show');

// routes with authentication
Route::group(['middleware' => ['apiJwt']], function () {
    Route::post('logout', 'AuthController@logout');


    //book routes
    Route::get('book', 'BookController@index');
    Route::get('book/{id}', 'BookController@show');
    Route::post('book', 'BookController@store');
    Route::put('book/{id}', 'BookController@update');
    Route::delete('book/{id}', 'BookController@destroy');

    //category routes
    Route::get('category/{id}', 'CategoryController@show');

    //library routes
    Route::get('library', 'LibraryController@index');

    //admin routes
    Route::group(['middleware' => ['apiHasRole']], function () {
        Route::post('user', 'UserController@store');
        Route::put('user/{id}', 'UserController@update');
        Route::delete('user/{id}', 'UserController@destroy');

        //category routes
        Route::post('category', 'CategoryController@store');
        Route::delete('category/{id}', 'CategoryController@destroy');
        Route::put('category/{id}', 'CategoryController@update');

        //library routes
        Route::get('library/{id}', 'LibraryController@show');
        Route::put('library/{id}', 'LibraryController@update');
        Route::post('library', 'LibraryController@store');
        Route::post('library/{id}/book/{bookId}', 'LibraryController@addBook');
        Route::delete('library/{id}', 'LibraryController@destroy');
        Route::delete('library/{id}/book/{bookId}', 'LibraryController@deleteBook');
    });
});
