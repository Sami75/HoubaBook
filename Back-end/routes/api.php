<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/user/signup', [
	'uses' => 'UserController@signup',
]);

Route::post('/user/signin', [
	'uses' => 'UserController@signin'
]);

Route::get('/users', [
	'uses' => 'UserController@getUsers',
	'middleware' => 'auth.jwt'
]);

Route::get('/friends', [
	'uses' => 'UserController@getFriends',
	'middleware' => 'auth.jwt'
]);

Route::get('/user/{id}', [
	'uses' => 'UserController@getUser',
	'middleware' => 'auth.jwt'
]);

Route::get('/isMyFriend/{id}', [
	'uses' => 'UserController@ismyfriend',
	'middleware' => 'auth.jwt'
]);

Route::put('/edit/{id}', [
	'uses' => 'UserController@edit',
	'middleware' => 'auth.jwt'
]);

Route::post('/newUserAmi', [
	'uses' => 'UserController@newUserAmis',
	'middleware' => 'auth.jwt'
]);

Route::post('/send/{id}', [
	'uses' => 'UserController@send',
	'middleware' => 'auth.jwt'
]);

Route::put('/accept/{id}', [
	'uses' => 'UserController@accept',
	'middleware' => 'auth.jwt'
]);

Route::delete('/delete/{id}', [
	'uses' => 'UserController@delete',
	'middleware' => 'auth.jwt'
]);

Route::delete('/refuse/{id}', [
	'uses' => 'UserController@refuse',
	'middleware' => 'auth.jwt'
]);

Route::delete('/annuler/{id}', [
	'uses' => 'UserController@annuler',
	'middleware' => 'auth.jwt'
]);

Route::post('search/{search}', [
	'uses' => 'UserController@search'
]);