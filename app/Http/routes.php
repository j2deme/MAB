<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PublicController@index')->name('root');

# Route::auth(); # Removed in order to name auth routes

# LOG IN/OUT Routes
Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

# REGISTRATION ROUTES
Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

# PASSWORD RESET ROUTES
Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);

# CUSTOM CONTROLLERS
Route::get('/home', 'HomeController@index')->name('home.index');

# USER ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'users', 'as' => 'users.'], function () {
  Route::get('/', 'UserController@index')->name('index');
  Route::post('/', 'UserController@store')->name('save');
  Route::get('/create', 'UserController@create')->name('new');
  Route::get('/{user}', 'UserController@show')->name('show');
  Route::get('/{user}/edit', 'UserController@edit')->name('edit');
  Route::put('/{user}', 'UserController@update')->name('update');
  Route::delete('/{user}', 'UserController@destroy')->name('delete');
});

Route::group(['middleware' => 'auth', 'prefix' => 'moves', 'as' => 'moves.'], function () { });
