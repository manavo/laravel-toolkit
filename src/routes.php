<?php

Route::group(['before' => 'guest'], function() {
	Route::get('register', '\Manavo\LaravelToolkit\Controllers\AuthController@getRegister');
	Route::post('register', '\Manavo\LaravelToolkit\Controllers\AuthController@postRegister')->before('csrf');
	Route::get('login', '\Manavo\LaravelToolkit\Controllers\AuthController@getLogin');
	Route::post('login', '\Manavo\LaravelToolkit\Controllers\AuthController@postLogin')->before('csrf');

	Route::controller('password', '\Manavo\LaravelToolkit\Controllers\RemindersController');
});

Route::group(['before' => 'auth'], function() {
    Route::get('settings', '\Manavo\LaravelToolkit\Controllers\SettingsController@getIndex');
    Route::post('settings', '\Manavo\LaravelToolkit\Controllers\SettingsController@postIndex')->before('csrf');

	Route::get('logout', function() {
		Auth::logout();

		if (Input::get('return')) {
			return Redirect::to(Input::get('return'));
		} else {
			return Redirect::to('/');
		}
	});
});
