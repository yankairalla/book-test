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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'AuthController@login');

Route::group(['middleware' => ['apiJwt']], function () {
    Route::get('user', 'UserController@index');

    Route::group(['middleware' => ['apiHasRole']], function () {
        Route::post('user', 'UserController@store');
    });
});


Route::post('user/{id}', 'UserController@show');


