<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'any_role:admin'], function () {
        // Admin routes
        Route::get('/createalbum', array('as' => 'create_album_form','uses' => 'AlbumsController@getForm'));
        Route::post('/createalbum', array('as' => 'create_album','uses' => 'AlbumsController@postCreate'));
        Route::get('/editalbum/{id}', array('as' => 'edit_album_form','uses' => 'AlbumsController@getEditForm'));
        Route::post('/editalbum', array('as' => 'edit_album','uses' => 'AlbumsController@postEdit'));
        Route::get('/deletealbum/{id}', array('as' => 'delete_album','uses' => 'AlbumsController@getDelete'));

    });

    Route::group(['middleware' => 'any_role:admin,manager'], function () {
        // Manager routes
        // Old:
        //Route::get('upload', 'FileController@create');
        //Route::post('upload','FileController@store');

        Route::get('/addimage/{id}', array('as' => 'add_image','uses' => 'ImagesController@getForm'));
        Route::get('/addimage', array('as' => 'add_image_free','uses' => 'ImagesController@getFormFree'));
        Route::post('/addimage', array('as' => 'add_image_to_album','uses' => 'ImagesController@postAdd'));
        Route::post('/moveimage', array('as' => 'move_image', 'uses' => 'ImagesController@postMove'));
        Route::get('/deleteimage/{id}', array('as' => 'delete_image','uses' => 'ImagesController@getDelete'));

    });

    Route::group(['middleware' => 'any_role:admin,manager,user'], function () {
        // User routes
        Route::get('/changePassword','HomeController@showChangePasswordForm');
        Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

        Route::get('/home', 'HomeController@index')->name('home');

    });
});

// Public routes
Route::get('/', array('as' => 'index','uses' => 'AlbumsController@getList'));
Route::get('/album/{id}', array('as' => 'show_album','uses' => 'AlbumsController@getAlbum'));
Route::get('/search','ImagesController@search')->name('search');


















// Old routes
/*
Route::get('/', function () {
    return view('welcome');
});

//Admin routes
Route::group(['middleware' => ['can:isAdmin']], function() {
    // your routes
    Route::get('upload', 'FileController@create');
    Route::post('upload','FileController@store');
});

//Manager routes
Route::group(['middleware' => ['can:isManager']], function() {
    // your routes
    Route::get('upload', 'FileController@create');
    Route::post('upload','FileController@store');
});

//User routes
Route::group(['middleware' => ['can:isUser']], function() {
    // your routes
    
});

Route::get('upload', 'FileController@create')->middleware('can:isAdmin')->name('upload');
Route::post('file','FileController@store')->middleware('can:isAdmin||can:isManager');
*/

