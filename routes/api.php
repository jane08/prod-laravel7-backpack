<?php

use App\Http\Controllers\Api\v1\BenefitController;
use App\Http\Controllers\Api\v1\StaticTransController;

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
    Route::get('/benefits', [BenefitController::class, 'index']);


});

/* Получение перевода по переданной странице */
Route::group(['middleware' => ['checkPage', 'lang']], function () {
    Route::get('/static-content/{page_code}', [StaticTransController::class, 'showPage']);

});

//Route::middleware('auth:api')->post('/register', [UserController::class, 'register']);




