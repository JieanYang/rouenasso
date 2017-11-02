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
	return Auth::user();
})->middleware('auth.basic.once');

/**
 * RESTful api
 */
Route::resource('users', 'UserController');
Route::resource('posts', 'PostController')->middleware('auth.basic.once');

Route::get('users/{id}/posts', 'UserController@showPostsByUserId')->middleware('auth.basic.once');
Route::get('posts/category/{id}', 'PostNoAuthController@showPostsByCategoryId');
Route::get('posts/{id}/noauth', 'PostNoAuthController@showPost');
Route::get('posts/category/{id}/drafts', 'PostController@showDraftsByCategoryId')->middleware('auth.basic.once');

Route::post('/register/{link}',['uses'=>'UserController@store']); //随机链接路由注册
Route::post('/createlink',['uses'=>'CreatelinkController@store'])->middleware('auth.basic.once');//测试创建链接
Route::post('/register',[
  'uses' => 'UserController@store'
]);

/**
 * Home
 */
Route::get('/home', 'HomeController@index')->name('home');
