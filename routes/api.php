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
    
    //admin routes
    Route::group(['middleware' => ['apiHasRole']], function () {
        Route::post('user', 'UserController@store');
        Route::put('user/{id}', 'UserController@update');
        Route::delete('user/{id}', 'UserController@destroy');
    });
});


Route::get('category/{id}', 'CategoryController@show');



