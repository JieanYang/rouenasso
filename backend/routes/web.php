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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function() {
	
});



/**
 * RESTful api
 */
Route::resource('users', 'UserController')->middleware('auth.basic.once');
Route::resource('posts', 'PostController')->middleware('auth.basic.once');

Route::get('users/{id}/posts', 'UserController@showPostsByUserId')->middleware('auth.basic.once');

/**
 * Auth
 */
//Auth::routes();
// Login
//Route::get('login', 'Auth\LoginController@showLoginForm');
//Route::post('login', 'Auth\LoginController@login')->name('login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//Route::get('logout', 'Auth\LoginController@logout');
// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm');
Route::post('register', 'Auth\RegisterController@register')->name('register');
// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/**
 * Home
 */
Route::get('/home', 'HomeController@index')->name('home');

/**
 * All other page redirect to 404 error
 */
Route::any('{all}', function(){
    return view('404');
})->where('all', '.*');
