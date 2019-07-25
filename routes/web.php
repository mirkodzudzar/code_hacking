<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//========> PRACTICE <========



// //returns 'fallback' if user does not enter value of id
// Route::get('users/{id?}', function($id = 'fallbackId'){
//     return $id;
// });

// //value of an id must be an integer 0-9
// Route::get('users/{id}', function($id){
//   return $id;
// })->where('id', '[0-9]+');

// //Value od username must be a string with characters from A to Z(a to z)
// Route::get('users/{username}', function($username){
//   return $username;
// })->where('username', '[A-Za-z]+');

// //id must be an integer. slug must be a stirng with characters A-Z, a-z
// Route::get('posts/{id}/{slug}', function($id, $slug){
//   echo $id.", ".$slug;
// })->where(['id' => '[0-9]+', 'slug' => '[A-Za-z]+']);
















// Route::get('/', function () {
//     return view('auth.login');
// });

$router->get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

// Route::get('/home', 'HomeController@index');

//admin prefix adds admin at the beginning of every route at this group
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function(){

  Route::get('/', function(){

    return view('admin.index');

  });

  Route::resource('users', 'AdminUsersController', ['names' => [

    'index' => 'admin.users.index',
    'create' => 'admin.users.create',
    'store' => 'admin.users.store',
    'edit' => 'admin.users.edit',

    ]]);

  // Route::get('/post/{id}', ['as' => 'home.post' , 'uses' => 'AdminPostsController@post']);

  Route::resource('posts', 'AdminPostsController', ['names' => [

    'index' => 'admin.posts.index',
    'create' => 'admin.posts.create',
    'store' => 'admin.posts.store',
    'edit' => 'admin.posts.edit',
    'show' => 'admin.posts.show',

    ]]);

  Route::resource('categories', 'AdminCategoriesController', ['names' => [

    'index' => 'admin.categories.index',
    'create' => 'admin.categories.create',
    'store' => 'admin.categories.store',
    'edit' => 'admin.categories.edit',
    'show' => 'admin.categories.show',

    ]]);

  Route::resource('media', 'AdminMediasController', ['names' => [

    'index' => 'admin.media.index',
    'create' => 'admin.media.create',
    'store' => 'admin.media.store',
    'edit' => 'admin.media.edit',
    'show' => 'admin.media.show',

    ]]);

  Route::delete('delete/media', 'AdminMediasController@deleteMedia');

  Route::resource('comments', 'PostCommentsController', ['names' => [

    'index' => 'admin.comments.index',
    'create' => 'admin.comments.create',
    'store' => 'admin.comments.store',
    'edit' => 'admin.comments.edit',
    'show' => 'admin.comments.show',

    ]]);

  Route::resource('comment/replies', 'CommentRepliesController', ['names' => [

    'index' => 'admin.comment.replies.index',
    'create' => 'admin.comment.replies.create',
    'store' => 'admin.comment.replies.store',
    'edit' => 'admin.comment.replies.edit',
    'show' => 'admin.comment.replies.show',

    ]]);

});

Route::get('/post/{id}', ['as' => 'home.post' , 'uses' => 'AdminPostsController@post']);

Route::group(['middleware' => 'auth'], function(){

  Route::post('comment/reply', 'CommentRepliesController@createReply');

});
