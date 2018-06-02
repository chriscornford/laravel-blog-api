<?php

use App\Http\Resources\Post as PostResource;
use App\Post;

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

Route::post('users', 'Api\UserController@store');

Route::apiResource('posts', 'Api\PostController')->only([
    'store', 'update', 'destroy'
])->middleware('auth:api');

Route::get('/posts/{id}', function ($id) {
    return new PostResource(Post::find($id));
});

Route::get('/posts', function () {
    return PostResource::collection(Post::paginate());
});
