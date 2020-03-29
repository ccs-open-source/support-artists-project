<?php

Route::get('/general', 'ProfileController@index')->name('index');
Route::post('/update', 'ProfileController@update')->name('update');
Route::get('/social', 'ProfileController@social')->name('social');
Route::get('/stream', 'ProfileStreamController@index')->name('stream');
Route::post('/stream', 'ProfileStreamController@store')->name('stream.store');
Route::get('/stream/create', 'ProfileStreamController@create')->name('stream.create');
Route::get('/stream/edit/{stream}', 'ProfileStreamController@edit')->name('stream.edit');
Route::get('/stream/delete/{stream}', 'ProfileStreamController@delete')->name('stream.delete');
