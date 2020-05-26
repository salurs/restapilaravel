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



Route::namespace('Api')->group(function (){
    Route::post('/auth/login','AuthController@login');

    Route::apiResource('users','UserController')->middleware('auth:api');
    Route::apiResource('categories','CategoryController')->middleware('token.bearer');
    Route::apiResource('products','ProductController')->middleware('auth.basic');
});

