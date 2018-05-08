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

Route::get('/', function () { return view('welcome'); });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function() { // code use in order to redirect user if NOT login
    // your routes
    Route::get('/post',     'PostController@index')->name('post');
    Route::get('/profile',  'ProfileController@index')->name('profile'); //route
    Route::get('/category', 'CategoryController@index'); //url

    Route::get('/view-article/{id}', 'PostController@viewPost');
    Route::get('/edit-article/{id}', 'PostController@editPost');
    Route::post('/edit-article/{id}', 'PostController@editPostP');
    Route::get('/delete-article/{id}', 'PostController@deletePost');

    Route::get('/add-category','CategoryController@index');
    Route::post('/add-category','CategoryController@addCategory');

    Route::get('/add-profile', 'ProfileController@index');
    Route::post('/add-profile', 'ProfileController@addProfile');

    Route::get('/add-post', 'PostController@index');
    Route::post('/add-post', 'PostController@addPost');

    Route::get('/category/{id}', 'CategoryController@retrieveByCategory');

    Route::get('/like/{id}', 'PostController@like');
    Route::get('/dislike/{id}', 'PostController@dislike');

    Route::post('/comment/{id}', 'PostController@comment');

    Route::post('/search', 'PostController@search');
});


