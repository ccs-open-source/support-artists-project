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


// Providers
Route::name('register.')
    ->prefix('/register/{provider}')
    ->group(base_path('routes/web/login-provider.php'));

// Home Endpoints
Route::name('home.')
    ->prefix('/')
    ->group(base_path('routes/web/home.php'));

// Profiles
Route::name('profile.')
    ->prefix('profile')
    ->middleware('auth:web-artists')
    ->group(base_path('routes/web/profile.php'));


Route::get('/stream/{stream}', ['as' => 'stream.detail', 'uses' => 'StreamDetailController@index']);

Route::get('/artist/red-hot-chili-peppers', function () {
    return view('pages.artists.detail', [
        'artist' => [
            'name' => 'Red Hot Chili Peppers'
        ]
    ]);
});

Route::get('/artists', 'ArtistController@index');

