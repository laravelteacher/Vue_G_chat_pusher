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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// this routs can send new message , delete Group and remove a Message
Route::get('/chats/{id}/', 'App\Http\Controllers\ChatController@index');
Route::get('/messages/{id}/', 'App\Http\Controllers\ChatController@fetchAllMessages');
Route::post('/messages/{id}/', 'App\Http\Controllers\ChatController@sendMessage');
Route::post('/delete/{code}', 'App\Http\Controllers\ChatController@destroy');
Route::DELETE('/delete/{id}/', 'App\Http\Controllers\ChatController@delete');

// in this routs we can create Group and Subscribe a Group
Route::get('/group/create', 'App\Http\Controllers\GroupController@create_form');
Route::post('/group/create', 'App\Http\Controllers\GroupController@create');
Route::get('/group/join', 'App\Http\Controllers\GroupController@join_form');
Route::post('/group/join', 'App\Http\Controllers\GroupController@join');

Route::get('/subscribe', 'App\Http\Controllers\ChatController@subscribe');
