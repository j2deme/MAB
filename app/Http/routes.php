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
Route::get('/test', 'PublicController@test')->name('test');
Route::get('/loadGroups', 'GroupController@load');

# Route::auth(); # Removed in order to name auth routes

# LOG IN/OUT Routes
Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

# REGISTRATION ROUTES
//Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
//Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

# PASSWORD RESET ROUTES
Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);

# CUSTOM CONTROLLERS
Route::get('/home', 'HomeController@index')->name('home.index');

# USER ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'users', 'as' => 'users.'], function () {
  Route::get('/', 'UserController@index')->name('index');
  Route::get('/clone', 'UserController@cloneStudents')->name('cloneStudents');
  Route::post('/save', 'UserController@store')->name('save');
  Route::get('/create', 'UserController@create')->name('new');
  Route::get('/{user}', 'UserController@show')->name('show');
  Route::get('/{user}/edit', 'UserController@edit')->name('edit');
  Route::put('/{user}', 'UserController@update')->name('update');
  Route::put('/s/{user}', 'UserController@selfUpdate')->name('selfUpdate');
  Route::delete('/{user}', 'UserController@destroy')->name('delete');
  Route::get('/toggle/{user}', 'UserController@toggle')->name('toggle');
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
  Route::post('/', 'MovesController@store')->name('save');
  Route::get('/create/{type}', 'MovesController@create')->name('new');
  Route::get('/{move}', 'MovesController@show')->name('show');
  Route::get('/{move}/edit', 'MovesController@edit')->name('edit');
  Route::put('/{move}', 'MovesController@update')->name('update');
  Route::delete('/{move}', 'MovesController@destroy')->name('delete');
  Route::delete('/c/{move}', 'MovesController@cancel')->name('cancel');
  # Filter by career
  Route::get('/by/career/{career}', 'MovesController@byCareer')->name('byCareer');
  # Filter by subject
  Route::get('/by/subject', 'MovesController@listBySubject')->name('listBySubject');
  Route::get('/by/subject/{subject}', 'MovesController@bySubject')->name('bySubject');
  # Filter by generation
  Route::get('/by/student', 'MovesController@listByStudent')->name('listByStudent');
  Route::get('/by/student/switch', 'MovesController@listPermutas')->name('listByGroups');
  Route::get('/by/student/{student}', 'MovesController@byStudent')->name('byStudent');
  # Filter by status
  Route::get('/by/status/registered', 'MovesController@byTypeRegistered')->name('listRegistered');
  Route::get('/by/status/revision', 'MovesController@byTypeRevision')->name('listOnRevision');
  Route::get('/by/status/attended', 'MovesController@byTypeAttended')->name('listAttended');
  Route::get('/switch/group', 'MovesController@switchGroup')->name('switchGroup');
  Route::post('/switch/group', 'MovesController@saveSwitchGroup')->name('saveSwitchGroup');
});

# PERMUTA ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'permutas', 'as' => 'permutas.'], function () {
  Route::get('/', 'PermutasController@index')->name('index');
  Route::post('/', 'PermutasController@store')->name('save');
  Route::get('/create', 'PermutasController@create')->name('new');
  Route::get('/{permuta}', 'PermutasController@show')->name('show');
  Route::get('/{permuta}/edit', 'PermutasController@edit')->name('edit');
  Route::put('/{permuta}', 'PermutasController@update')->name('update');
  Route::delete('/{permuta}', 'PermutasController@destroy')->name('delete');
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
  Route::get('/toggle/{semester}', 'SemesterController@toggle')->name('toggle');
});

# CAREER ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'careers', 'as' => 'careers.'], function () {
  Route::get('/', 'CareerController@index')->name('index');
  Route::post('/', 'CareerController@store')->name('save');
  Route::get('/create', 'CareerController@create')->name('new');
  Route::get('/{career}', 'CareerController@show')->name('show');
  Route::get('/{career}/edit', 'CareerController@edit')->name('edit');
  Route::put('/{career}', 'CareerController@update')->name('update');
  Route::delete('/{career}', 'CareerController@destroy')->name('delete');
});

# SUBJECT ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'subjects', 'as' => 'subjects.'], function () {
  Route::get('/', 'SubjectController@index')->name('index');
  Route::post('/', 'SubjectController@store')->name('save');
  Route::get('/sync', 'SubjectController@sync')->name('sync');
  Route::get('/create', 'SubjectController@create')->name('new');
  Route::get('/{subject}', 'SubjectController@show')->name('show');
  Route::get('/{subject}/edit', 'SubjectController@edit')->name('edit');
  Route::put('/{subject}', 'SubjectController@update')->name('update');
  Route::delete('/{subject}', 'SubjectController@destroy')->name('delete');
  Route::get('/load', 'SubjectController@batch')->name('batch');
  Route::get('/toggle/{subject}', 'SubjectController@toggle')->name('toggle');
});

# GROUP ROUTES -- RESOURCE
Route::group(['middleware' => 'auth', 'prefix' => 'groups', 'as' => 'groups.'], function () {
  Route::get('/', 'GroupController@index')->name('index');
  Route::post('/', 'GroupController@store')->name('save');
  Route::get('/sync', 'GroupController@sync')->name('sync');
  Route::get('/create', 'GroupController@create')->name('new');
  Route::get('/{group}', 'GroupController@show')->name('show');
  Route::get('/{group}/edit', 'GroupController@edit')->name('edit');
  Route::put('/{group}', 'GroupController@update')->name('update');
  Route::delete('/{group}', 'GroupController@destroy')->name('delete');
  Route::get('/load', 'GroupController@load')->name('batch');
  Route::get('/toggle/{group}', 'GroupController@toggle')->name('toggle');
});
