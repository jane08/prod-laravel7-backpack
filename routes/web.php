<?php

use App\Http\Controllers\Admin\ErrorController;
use App\Http\Controllers\Front\CourseController;
use App\Http\Controllers\Front\MailChimpController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\PdfController;
use App\Http\Controllers\Front\SiteController;
use App\Http\Controllers\Front\SitemapController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;

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
//Route::redirect('/', '/en');
Route::group([
    'namespace'  => 'App\Http\Controllers\Front',
   // 'prefix' => '{lang?}'
], function () { // custom admin routes


    Route::get('/', [SiteController::class, 'index'])->name("main");

    Route::get('/checkout', [PaymentController::class, 'checkout'])->name("checkout");
    Route::post('/purchase', [PaymentController::class, 'purchase'])->name("purchase");

    Route::get('/thank-you', [PaymentController::class, 'thankyou'])->name("thank-you");


    Route::get('{lang?}/contact', [SiteController::class, 'contact'])->name("contact");
    Route::post('send-feedback', [SiteController::class, 'sendFeedback'])->name("send-feedback");
    Route::get('{lang?}/', [SiteController::class, 'index'])->name("main");

    Route::get('{lang?}/benefits', [SiteController::class, 'benefits'])->name("benefits");

    Route::get('{lang?}/{slug}', [SiteController::class, 'page'])->name("page");
});


Route::get('/error',  [ErrorController::class, 'error401'])->name('error401');

Route::group([
    'namespace'  => '\App\Http\Controllers\Admin',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware(), 'customAdmin'],
], function () {
    Route::crud('user', 'UserCrudController');
    Route::crud('permission', 'PermissionCrudController');
    Route::crud('role', 'RoleCrudController');
});


