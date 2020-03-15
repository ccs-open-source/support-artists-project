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

// Register Callbacks
Route::get('/register/{provider}', ['as' => 'register', 'uses' => 'SocialLoginController@redirectToProvider']);
Route::get('/register/{provider}/callback', 'SocialLoginController@handleProviderCallback');

// Home Controllers
Route::group(['prefix' => '/', 'as' => 'home.'], function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/register', 'HomeController@register')->name('register');
    Route::get('/complete-registration', ['as' => 'complete-registration', 'uses' => 'HomeController@completeRegistration']);
    Route::post('/complete-registration', ['as' => 'complete-registration', 'uses' => 'HomeController@finishedRegistration']);

    Route::get('js/lang.js', 'AssetsController@lang')->name('assets.lang');
    Route::get('js/lang.{file}.js', 'AssetsController@langByFile')->name('assets.lang.file');
    Route::get('version.txt', 'AssetsController@getVersion')->name('assets.version');
});

Route::get('/stream/{stream}', ['as' => 'stream.detail', 'uses' => 'StreamDetailController@index']);

Route::get('/artist/red-hot-chili-peppers', function () {
    return view('pages.artists.detail', [
        'artist' => [
            'name' => 'Red Hot Chili Peppers'
        ]
    ]);
});

Route::get('/artists', 'ArtistController@index');

