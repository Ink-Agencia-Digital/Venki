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

Route::get('/register/verify/{code}', 'GuestController@verify');
Route::post('password/email', 'Auth\ForgotPasswordController@forgot');
Route::post('password/reset', 'Auth\ForgotPasswordController@reset');
Route::post('oauth/token', 'Auth\LoginController@login');
Route::post('users', 'User\UserController@store');

Route::middleware('auth:api')->group(function () {
    /**
     * User Auth
     */
    Route::get('user', function (Request $request) {
        return $request->user()->load(['profile', 'roles', 'achievements']);
    });

    /**
     * Users
     */
    Route::resource('users', 'User\UserController', ['except' => ['create', 'edit', 'store']]);
    Route::resource('users.courses', 'User\UserCourseController', ['except' => ['create', 'edit']]);
    Route::get('users/{iduser}/course/{idcourse}','User\UserCourseLessonController@index');
    Route::post('users/course/lesson','User\UserCourseLessonController@store');
    Route::resource('users.scores', 'User\UserScoreController', ['except' => ['create', 'edit']]);
    Route::resource('users.devices', 'User\UserDeviceController', ['except' => ['create', 'edit']]);
    Route::resource('users.chats', 'User\UserChatController', ['except' => ['create', 'edit']]);
    Route::resource('users.posts', 'User\UserPostController', ['only' => ['index']]);
    Route::resource('users.replies', 'User\UserReplyController', ['only' => ['index']]);
    Route::resource('users.recomendations', 'User\UserRecomendationController', ['only' => ['index']]);
    Route::resource('users.timelines', 'User\UserTimelineController', ['only' => ['index']]);
    Route::resource('users.achievements', 'User\UserAchievementController', ['only' => ['index']]);
    Route::resource('users.feelings', 'User\UserFeelingController', ['only' => ['index']]);
    Route::resource('users.coins', 'User\UserCoinController', ['only' => ['index']]);
    Route::resource('users.competences', 'User\UserCompetenceController', ['only' => ['index']]);
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
    Route::resource('categoriesChildren', 'Category\CategoryChildrenController', ['only' => ['index']]);
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
    Route::resource('surveys.questions', 'Survey\SurveyQuestionController', ['except' => ['create', 'edit']]);
    Route::resource('surveys.category.questions', 'Survey\SurveyCategoryQuestionController', ['only' => ['index']]);
    /**
     * Reply
     */
    Route::resource('replies', 'Reply\ReplyController', ['except' => ['create', 'edit']]);
    /**
     * Question
     */
    Route::resource('questions', 'Question\QuestionController', ['except' => ['create', 'edit']]);
    Route::resource('questions.answers', 'Question\QuestionAnswerController', ['only' => ['index']]);
    /**
     * Answer
     */
    Route::resource('answers', 'Answer\AnswerController', ['except' => ['create', 'edit']]);
    /**
     * Examen
     */
    Route::resource('exams', 'Exam\ExamController', ['except' => ['create', 'edit']]);
    /**
     * Recomendation
     */
    Route::resource('recomendations', 'Recomendation\RecomendationController', ['except' => ['create', 'edit']]);
    /**
     * DailyActivity
     */
    Route::resource('dailyactivities', 'DailyActivity\DailyActivityController', ['except' => ['create', 'edit']]);
    /**
     * Achievements
     */
    Route::resource('achievements', 'Achievement\AchievementController', ['except' => ['create', 'edit']]);
    /**
     * Feelings
     */
    Route::resource('feelings', 'Feeling\FeelingController', ['except' => ['create', 'edit']]);
    /**
     * Coins
     */
    Route::resource('coins', 'Coin\CoinController', ['except' => ['create', 'edit']]);
    /**
     * Competences
     */
    Route::resource('competences', 'Competence\CompetenceController', ['except' => ['create', 'edit']]);
    /**
     * Images
     */
    Route::resource('images', 'Image\ImageController', ['except' => ['create','edit']]);
    /**
     * Membresias
     */
    Route::resource('membresias','Membresias\MembresiasController',['except' => ['create', 'edit']]);
    /**
     * Quiz
     */
    Route::resource('quiz','quiz\quizController',['except' => ['create', 'edit']]);
    Route::resource('user.quiz','quiz\quizuserController',['only'=>['index']]);
    /**
     * Examen
     */
    Route::resource('examen','Examen\examenController',['except'=>['create','edit']]);
    Route::resource('preguntaexamen','Examen\preguntaexamenController',['except'=>['create','edit']]);
    Route::get('examen/{idexamen}/preguntas','Examen\examenpreguntasController@index');
    Route::get('examen/{idcourse}/course','Examen\examenController@index');
    Route::post('respuesta/examen','Examen\respuestaExamenController@store');
    Route::get('respuestas/user/{iduser}/examen/{idexamen}','Examen\respuestaExamenController@index');
    Route::post('examen/calificacion','Examen\respuestaExamenController@update');
    Route::get('examen/resultados/user/{iduser}','Examen\resultadoExamenController@index');
    /**
     * Trofeos
     */
    Route::resource('trofeos','Trofeo\trofeoController',['except'=>['create','edit']]);
    /**
     * Notifications push
     */
    Route::resource('notifications','Notification\notificationController',['except'=>['create','edit']]);
});
