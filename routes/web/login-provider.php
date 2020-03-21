<?php

Route::get('/', ['as' => 'provider', 'uses' => 'SocialLoginController@redirectToProvider']);
Route::get('/callback', 'SocialLoginController@handleProviderCallback');
