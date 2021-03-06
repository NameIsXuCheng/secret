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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::post('login', 'AuthController@login');
//Route::middleware("auth:api")->group(function () {
//    Route::post('logout', 'AuthController@logout');
//    Route::post('refresh', 'AuthController@refresh');
//    Route::get('me', 'AuthController@me');
//});

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser');

//    Route::get('products', 'ProductController@index');
//    Route::get('products/{id}', 'ProductController@show');
//    Route::post('products', 'ProductController@store');
//    Route::put('products/{id}', 'ProductController@update');
//    Route::delete('products/{id}', 'ProductController@destroy');
});