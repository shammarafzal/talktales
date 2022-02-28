<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return view('index');
})->middleware(['is_admin'])->name('index');


Route::resource('user', 'Admin\UserController')->middleware(['is_admin', 'auth']);
Route::get('fetchUsers', 'Admin\UserController@fetchUsers')->middleware(['is_admin', 'auth']);

Route::resource('notification', 'Admin\NotificationController')->middleware(['is_admin', 'auth']);
Route::get('fetchNotifications', 'Admin\NotificationController@fetchNotifications')->middleware(['is_admin', 'auth']);

Route::resource('book', 'Admin\BookController')->middleware(['is_admin', 'auth']);
Route::get('fetchBooks', 'Admin\BookController@fetchBooks')->middleware(['is_admin', 'auth']);

require __DIR__ . '/auth.php';
