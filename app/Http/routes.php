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
  Route::put('/{user}', 'UserController@selfUpdate')->name('selfUpdate');
  Route::delete('/{user}', 'UserController@destroy')->name('delete');
});

# ROLE ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'roles', 'as' => 'roles.'], function () {
  Route::get('/', 'RoleController@index')->name('index');
  Route::post('/', 'RoleController@create')->name('save');
  Route::put('{role}', 'RoleController@update')->name('update');
});

# MOVE ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'moves', 'as' => 'moves.'], function () {
  Route::get('/', 'MovesController@index')->name('index');
  Route::get('/create/{type}', 'MovesController@create')->name('new');
});

# SEMESTER ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'semesters', 'as' => 'semesters.'], function () {
  Route::get('/', 'SemesterController@index')->name('index');
  Route::post('/', 'SemesterController@store')->name('save');
  Route::get('/create', 'SemesterController@create')->name('new');
  Route::get('/{semester}', 'SemesterController@show')->name('show');
  Route::get('/{semester}/edit', 'SemesterController@edit')->name('edit');
  Route::put('/{semester}', 'SemesterController@update')->name('update');
  Route::delete('/{semester}', 'SemesterController@destroy')->name('delete');
});

# CAREER ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'careers', 'as' => 'careers.'], function () {
  Route::get('/', 'CareerController@index')->name('index');
  Route::post('/', 'CareerController@store')->name('save');
  Route::get('/create', 'CareerController@create')->name('new');
  Route::get('/{career}', 'CareerController@show')->name('show');
});
