<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('users.courses', 'User\UserCourseController', ['except' => ['create', 'edit']]);
Route::resource('courses', 'Course\CourseController', ['except' => ['create', 'edit']]);
Route::resource('courses.lessons', 'Course\CourseController', ['except' => ['create', 'edit']]);
Route::resource('lessons', 'Course\CourseController', ['except' => ['create', 'edit']]);
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
