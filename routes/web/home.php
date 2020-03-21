<?php

Route::get('/', 'HomeController@index')->name('index');
Route::post('/login', ['as' => 'login', 'uses' => 'LoginController@login']);
Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@index']);
Route::post('/logout', ['as' => 'logout', 'uses' => 'LogoutController@index']);
Route::get('/registration', ['as' => 'registration', 'uses' => 'HomeController@completeRegistration']);
Route::post('/registration', ['as' => 'registration', 'uses' => 'HomeController@finishedRegistration']);

Route::get('js/lang.js', 'AssetsController@lang')->name('assets.lang');
Route::get('js/lang.{file}.js', 'AssetsController@langByFile')->name('assets.lang.file');
Route::get('version.txt', 'AssetsController@getVersion')->name('assets.version');
