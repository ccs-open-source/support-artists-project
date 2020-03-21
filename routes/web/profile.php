<?php

Route::get('/general', 'ProfileController@index')->name('index');
Route::post('/update', 'ProfileController@update')->name('update');
Route::get('/social', 'ProfileController@social')->name('social');
