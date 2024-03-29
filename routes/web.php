<?php



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

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('board', 'BoardController')->except(['create', 'edit']);
Route::resource('board.card', 'Board\CardController')->except(['create', 'edit', 'show']);
Route::resource('board.card.task', 'Board\Card\TaskController')->except(['create', 'edit']);
Route::get("user", 'GetAuthUser');

