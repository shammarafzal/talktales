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
//AuthController Route
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');
Route::post('verifyToken', 'AuthController@verifyToken');
Route::post('verifyEmail', 'AuthController@verifyEmail');
Route::get('user', 'AuthController@user')->middleware('auth:sanctum');
Route::get('fetchBooks', 'BookController@fetchBooks')->middleware('auth:sanctum');
Route::post('searchBooks', 'BookController@search')->middleware('auth:sanctum');
