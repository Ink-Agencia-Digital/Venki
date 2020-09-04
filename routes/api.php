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

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user()->load(['profile', 'roles']);
});

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

/** 
 * Users
 */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('users.courses', 'User\UserCourseController', ['except' => ['create', 'edit']]);
Route::resource('users.scores', 'User\UserScoreController', ['except' => ['create', 'edit']]);
Route::resource('users.devices', 'User\UserDeviceController', ['except' => ['create', 'edit']]);
Route::resource('users.chats', 'User\UserChatController', ['except' => ['create', 'edit']]);
Route::resource('users.posts', 'User\UserPostController', ['only' => ['index']]);
Route::resource('users.replies', 'User\UserReplyController', ['only' => ['index']]);
/** 
 * Courses
 */
Route::resource('courses', 'Course\CourseController', ['except' => ['create', 'edit']]);
Route::resource('courses.lessons', 'Course\CourseLessonController', ['except' => ['create', 'edit']]);
Route::resource('courses.scores', 'Course\CourseScoreController', ['except' => ['create', 'edit']]);
/** 
 * Lessons
 */
Route::resource('lessons', 'Lesson\LessonController', ['except' => ['create', 'edit']]);
Route::resource('lessons.resources', 'Lesson\LessonResourceController', ['except' => ['create', 'edit']]);
/** 
 * Resources
 */
Route::resource('resources', 'Resource\ResourceController', ['except' => ['create', 'edit']]);
/** 
 * Categories
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.courses', 'Category\CategoryCourseController', ['only' => ['index']]);
/**
 * Scores
 */
Route::resource('scores', 'Score\ScoreController', ['except' => ['create', 'edit']]);
/**
 * Devices
 */
Route::resource('devices', 'Device\DeviceController', ['except' => ['create', 'edit']]);
/**
 * Chat
 */
Route::resource('chats', 'Chat\ChatController', ['except' => ['create', 'edit']]);
Route::resource('chats.messages', 'Chat\ChatMessageController', ['except' => ['create', 'edit']]);
/**
 * Message
 */
Route::resource('messages', 'Message\MessageController', ['except' => ['create', 'edit']]);
/** 
 * Push
 */
Route::post('push', 'Push\PushController@sendPush');
/** 
 * Post
 */
Route::resource('posts', 'Post\PostController', ['except' => ['create', 'edit']]);
/** 
 * Profile 
 */
Route::resource('profiles', 'Profile\ProfileController', ['except' => ['create', 'edit']]);
Route::resource('profiles.questions', 'Profile\ProfileQuestionController', ['only' => ['index']]);
/**
 * Survey
 */
Route::resource('surveys', 'Survey\SurveyController', ['except' => ['create', 'edit']]);
/** 
 * Reply 
 */
Route::resource('replies', 'Reply\ReplyController', ['except' => ['create', 'edit']]);
