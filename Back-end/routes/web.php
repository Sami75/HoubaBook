<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Routes permettant l'affichage des vues.

Route::get('/', 'HomeController@index')->name('home');

Route::get('/account', 'UserController@index')->name('account');

Route::post('editAccount/{user}', 'UserController@edit')->name('editAccount');

Route::post('search', 'HomeController@search')->name('search');

Route::get('detailUser/{user}', 'UserController@show')->name('detailUser');

Route::get('sendFriend/{user}', 'UserController@send')->name('sendFriend');

Route::get('deleteFriend/{user}', 'UserController@delete')->name('deleteFriend');

Route::get('acceptFriend/{user}', 'UserController@accept')->name('acceptFriend');

Route::get('refuseFriend/{user}', 'UserController@refuse')->name('refuseFriend');

Route::get('annuler/{user}', 'UserController@annuler')->name('annuler');

Route::post('newUserAmi', 'UserController@newUserAmis')->name('newUserAmi');

