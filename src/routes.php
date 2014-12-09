<?php

Route::group(['before' => 'guest'], function() {
	Route::get('register', '\Manavo\LaravelToolkit\AuthController@getRegister');
	Route::post('register', '\Manavo\LaravelToolkit\AuthController@postRegister')->before('csrf');
	Route::get('login', '\Manavo\LaravelToolkit\AuthController@getLogin');
	Route::post('login', '\Manavo\LaravelToolkit\AuthController@postLogin')->before('csrf');

	Route::controller('password', '\Manavo\LaravelToolkit\RemindersController');
});

Route::group(['before' => 'auth'], function() {
    Route::get('settings', '\Manavo\LaravelToolkit\SettingsController@getIndex');
    Route::post('settings', '\Manavo\LaravelToolkit\SettingsController@postIndex')->before('csrf');

	Route::get('logout', function() {
		Auth::logout();

		if (Input::get('return')) {
			return Redirect::to(Input::get('return'));
		} else {
			return Redirect::to('/');
		}
	});
});
