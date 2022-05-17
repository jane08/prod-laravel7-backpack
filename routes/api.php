<?php

use App\Http\Controllers\Api\v1\BurseController;
use App\Http\Controllers\Api\v1\CabinetVideoReviewController;
use App\Http\Controllers\Api\v1\CityController;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\CourseController;
use App\Http\Controllers\Api\v1\KauriController;
use App\Http\Controllers\Api\v1\LessonController;
use App\Http\Controllers\Api\v1\LinkStatisticController;
use App\Http\Controllers\Api\v1\MainPageController;
use App\Http\Controllers\Api\v1\MyTeamController;
use App\Http\Controllers\Api\v1\NewsController;
use App\Http\Controllers\Api\v1\NotificationController;
use App\Http\Controllers\Api\v1\ProjectController;
use App\Http\Controllers\Api\v1\PromoController;
use App\Http\Controllers\Api\v1\StaticTransController;
use App\Http\Controllers\Api\v1\StatisticController;
use App\Http\Controllers\Api\v1\StrategyController;
use App\Http\Controllers\Api\v1\StrikeEventController;
use App\Http\Controllers\Api\v1\TariffController;
use App\Http\Controllers\Api\v1\TelegramController;
use App\Http\Controllers\Api\v1\TestController;
use App\Http\Controllers\Api\v1\UserController;
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

Route::get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('JsonWebTokenAuthenticate')->post('/static-trans',    [StaticTransController::class, 'index']);

/* Получение всех переводов всех страниц */
Route::group(['middleware' => ['lang']], function () {
    Route::get('/static-content', [StaticTransController::class, 'index']);
    Route::get('/main-page', [MainPageController::class, 'index']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{slug}', [NewsController::class, 'view']);
    Route::get('/tariffs', [TariffController::class, 'index']);

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/signin', [UserController::class, 'signin']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
    Route::post('/delete-reset-password', [UserController::class, 'deletePasswordReset']);

    /*callback kauri*/
    Route::post('/deposit-callback', [KauriController::class, 'depositCallBack']);
    Route::post('/usdt-callback', [KauriController::class, 'usdtCallBack']);

    Route::get('/cities', [CityController::class, 'index']);
    Route::get('/country', [CountryController::class, 'view']);
    Route::get('/country-by-name', [CountryController::class, 'viewByEnName']);
    Route::get('/countries', [CountryController::class, 'index']);

    Route::match(['GET'], '/referer-data', [UserController::class, 'refererData']);
    Route::match(['GET'], '/confirm-email', [UserController::class, 'confirmEmail']);

});

/* Получение перевода по переданной странице */
Route::group(['middleware' => ['checkPage', 'lang']], function () {
    Route::get('/static-content/{page_code}', [StaticTransController::class, 'showPage']);

});

//Route::middleware('auth:api')->post('/register', [UserController::class, 'register']);


Route::group(['middleware' => ['lang', 'checkToken']], function () {
    Route::get('/events', [StrikeEventController::class, 'index']);
    Route::get('/events/{slug}', [StrikeEventController::class, 'view']);
    Route::get('/promo', [PromoController::class, 'index']);
    Route::get('/reviews', [CabinetVideoReviewController::class, 'index']);
    Route::get('/statistics', [StatisticController::class, 'index']);

    Route::post('/user-security-settings/email', [UserController::class, 'changeEmail']);
    Route::post('/save-avatar', [UserController::class, 'saveAvatar']);
    Route::post('/user-security-settings/password', [UserController::class, 'changePassword']);
    Route::post('/user-security-settings/twofactor', [UserController::class, 'twofactor']);
    Route::get('/user-security-settings', [UserController::class, 'userSecuritySettings']);

    Route::post('/transaction', [KauriController::class, 'api']);
    Route::post('/usdt', [KauriController::class, 'usdt']);

    Route::get('/currency', [KauriController::class, 'currency']);

    Route::match(['GET', 'POST'], '/user-profile', [UserController::class, 'userProfile']);

    /* tests */

    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{slug}', [CourseController::class, 'view']);

    Route::get('/lessons', [LessonController::class, 'index']);
    Route::get('/get-current-lesson', [LessonController::class, 'getCurrentLesson']);
    Route::get('/lessons/{slug}', [LessonController::class, 'view']);

    Route::get('/questions', [TestController::class, 'index']);
    Route::post('/send-test', [TestController::class, 'sendTest']);

    Route::get('/homework', [TestController::class, 'homework']);
    Route::get('/homework-check', [TestController::class, 'homeworkCheck']);
    Route::post('/homework-status-change', [TestController::class, 'homeworkStatusChange']);


    Route::post('/buy-course', [CourseController::class, 'buyCourse']);

});

Route::group(['middleware' => ['lang', 'checkToken', 'checkTariff']], function () {
    Route::get('/auth-user-info', [UserController::class, 'authUserInfo']);
    Route::get('/user-notifications', [NotificationController::class, 'indexUnread']);
    Route::post('/user-notifications/id', [NotificationController::class, 'setRead']);
    Route::get('/strategy', [StrategyController::class, 'index']);
    Route::get('/projects', [ProjectController::class, 'index']);
    /* формирование реф ссылки для проекта */
    Route::post('/register/notif/{slug}', [ProjectController::class, 'notify']);
    Route::get('/services', [BurseController::class, 'index']);
    Route::get('/services-request', [BurseController::class, 'indexLink']);
    Route::get('/user-chats', [TelegramController::class, 'index']);
    Route::get('/user-team', [MyTeamController::class, 'index']);
    Route::get('/project/{slug}', [ProjectController::class, 'view']);
    //регистрация на проект
    Route::post('/register/{slug}', [LinkStatisticController::class, 'create']);

    // главная личного кабинета
    // Route::get('/main-page-pc',  [MainPageController::class, 'indexPc']);
    Route::get('/score', [UserController::class, 'score']);
    Route::match(['GET', 'POST'], '/user-profile', [UserController::class, 'userProfile']);


});

