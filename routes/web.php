<?php

use Illuminate\Support\Facades\Route;
use app\Http\controller\PostsController;

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

// Route::get('/', function () {
//     return '<h1>Welcome to the Laravel</h1>';
// });

// Route::get('/about', function () {
//     return view('pages.about');
// });

Route::resource('posts', 'App\Http\Controllers\PostsController');
Route::get('/', 'App\Http\Controllers\PagesController@index');
Route::get('/about', 'App\Http\Controllers\PagesController@about');
Route::get('/services', 'App\Http\Controllers\PagesController@services');
Route::post('/posts','App\Http\Controllers\PostsController@update');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
