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


// Route::get('foo', function () {
// 	return redirect()->route('posts.showPostsCalendar');
// });

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
Route::get('users/{id}/posts', 'UserController@showPostsByUserId')->name('users.countUser')->middleware('auth.basic.once');
Route::get('users/count/show', 'UserController@countUser')->name('users.showPostsByUserId')->middleware('auth.basic.once');

Route::post('login', 'GetSelfController@getSelf')->name('users.getSelf')->middleware('auth.basic.once');
Route::post('/register/{link}',['uses'=>'UserController@store'])->name('users.shore'); //随机链接路由注册
Route::post('/createlink',['uses'=>'CreatelinkController@store'])->name('links.store')->middleware('auth.basic.once');//测试创建链接



Route::resource('posts', 'PostController')->middleware('auth.basic.once');
Route::get('posts/category/{id}/drafts', 'PostController@showDraftsByCategoryId')->name('posts.showDraftsByCategoryId')->middleware('auth.basic.once');
Route::get('posts/calendar/show', 'PostController@showPostsCalendar')->name('posts.showPostsCalendar')->middleware('auth.basic.once');
Route::get('posts/count/show', 'PostController@countPost')->name('posts.countPost')->middleware('auth.basic.once');
Route::get('posts/category/{id}', 'PostNoAuthController@showPostsByCategoryId')->name('posts.showPostsByCategoryId');
Route::get('posts/{id}/noauth', 'PostNoAuthController@showPost')->name('posts.showPost');



// Movements
Route::resource('movements', 'MovementController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
// Works
Route::resource('works', 'WorkController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
// Writings
Route::resource('writings', 'WritingController', [ 'only' => ['index', 'show', 'store', 'update', 'destroy']]);
// LeaveMessages
Route::resource('leaveMessages', 'LeaveMessageController', [ 'only' => ['index', 'show', 'store', 'destroy']]);



/**
 * Neditor
 */
Route::get('editor', 'NeditorController@main');
Route::post('editor', 'NeditorController@main');

/**
 * View Log
 */
Route::get('log/', 'ViewLogController@addLog');
Route::get('log/today', 'ViewLogController@getTodayCount')->middleware('auth.basic.once');
Route::get('log/today/detail', 'ViewLogController@getToday')->middleware('auth.basic.once');
Route::get('log/oneday/{date}', 'ViewLogController@getOneDayCount')->middleware('auth.basic.once');
Route::get('log/oneday/{date}/detail', 'ViewLogController@getOneDay')->middleware('auth.basic.once');
Route::get('log/history', 'ViewLogController@getHistoryCount')->middleware('auth.basic.once');

/**
 * Home
 */
Route::get('/home', 'HomeController@index')->name('home');
