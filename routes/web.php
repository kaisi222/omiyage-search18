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

Route::group(['prefix' => 'users/{id}'], function () { 
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });
    

Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
});


//楽天検索用
//Route::group(['middleware' => 'auth'], function () {
//    Route::resource('gifts', 'GiftsController', ['only' => ['create']]);
//});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('items', 'ItemsController', ['only' => ['create']]);
});


//いいねボタン
Route::group(['middleware' => 'auth'], function () {
    Route::resource('items', 'ItemsController', ['only' => ['create', 'show']]);
    Route::post('want', 'ItemUserController@like')->name('item_user.like');
    Route::delete('want', 'ItemUserController@dont_like')->name('item_user.dont_like');
    Route::resource('users', 'UsersController', ['only' => ['show']]);
});


//ユーザー情報変更
Route::resource('users', 'UsersController');