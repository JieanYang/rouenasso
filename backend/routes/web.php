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

// Route::get('foo', function () {
// 	// 查看用户关联的东西
// 	$user = App\User::find(2);
// 	$postsNull = $user->movements()->whereNull('published_at')->get();
// 	$posts = $user->movements()->whereNotNull('published_at')->get();
// 	return $posts.$postsNull;

// 	// 查看东西关联的用户
// 	$post = App\Post::find(4);
// 	$user = $post->user()->get();
// 	return $user;
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
Route::post('/register/{link}',['uses'=>'UserController@store']); // 用户注册，需要链接
//另外加的API
Route::post('login', 'GetSelfController@getSelf');
Route::get('users/{id}/posts', 'UserController@showPostsByUserId');
Route::get('users/count/show', 'UserController@countUser');

Route::post('/createlink',['uses'=>'CreatelinkController@store']); //随机链接路由注册


//需要用户验证
Route::resource('posts', 'PostController');
Route::get('posts/count/show', 'PostController@countPost');
Route::get('posts/category/{id}/drafts', 'PostController@showDraftsByCategoryId');
Route::get('posts/calendar/show', 'PostController@showPostsCalendar');

//无需用户认证
Route::get('posts/category/{id}', 'PostNoAuthController@showPostsByCategoryId');
Route::get('posts/{id}/noauth', 'PostNoAuthController@showPost');

//editor 处理的图片上传和下载API
Route::post('uploadimg/', 'PostController@uploadImg');
Route::get('downloadimg/', 'PostNoAuthController@retrieveImg');


// LeaveMessages
Route::resource('leaveMessages', 'LeaveMessageController', [ 'only' => ['index', 'show', 'store', 'destroy']]);

// TrashCan
Route::get('TrashCans', 'TrashCanController@index');
Route::get('TrashCans/{id}', 'TrashCanController@show');
Route::put('TrashCans/{id}', 'TrashCanController@restore');
Route::delete('TrashCans/{id}', 'TrashCanController@forceDelete');


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
