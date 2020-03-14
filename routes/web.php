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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/artist/red-hot-chili-peppers', function () {
    return view('pages.artists.detail', [
        'artist' => [
            'name' => 'Red Hot Chili Peppers'
        ]
    ]);
});

Route::get('/artists', 'ArtistController@index');
Route::get('/register/{provider}', ['as' => 'register', 'uses' => 'SocialLoginController@redirectToProvider']);
Route::get('/register/{provider}/callback', 'SocialLoginController@handleProviderCallback');
