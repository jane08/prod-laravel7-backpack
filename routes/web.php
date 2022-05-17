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

Route::group([
    'namespace'  => 'App\Http\Controllers\Front',
], function () { // custom admin routes
    Route::get('/', [SiteController::class, 'index'])->name("main");
    Route::get('contact', [SiteController::class, 'contact'])->name("contact");
    Route::get('sitemap', [SitemapController::class, 'sitemap'])->name("sitemap");
    Route::post('send-feedback', [SiteController::class, 'sendFeedback'])->name("send-feedback");

    Route::get('/authentication', [SiteController::class, 'authentication'])->name("authentication");
    Route::post('/signup', [SiteController::class, 'signup'])->name("signup");
    Route::post('/login', [SiteController::class, 'login'])->name("login");
    Route::get('/logout', [SiteController::class, 'logout'])->name("logout");

    Route::get('/auth/facebook/redirect', [\App\Http\Controllers\Auth\FacebookController::class, 'handleFacebookRedirect'])->name("fb-redirect");
    Route::get('/auth/facebook/callback', [\App\Http\Controllers\Auth\FacebookController::class, 'handleFacebookCallback']);

    // reset password
    Route::get('/forgot-password-form', [SiteController::class, 'forgotPasswordForm'])->name("forgot-password-form");
    Route::post('/forgot-password', [SiteController::class, 'forgotPassword'])->name("forgot-password");

    Route::get('/recovery/{token?}', [SiteController::class, 'recovery'])->name("recovery");
    Route::post('/reset-password', [SiteController::class, 'resetPassword'])->name("reset-password");
    //end reset password

    Route::get('/checkout', [PaymentController::class, 'checkout'])->name("checkout");
    Route::post('/purchase', [PaymentController::class, 'purchase'])->name("purchase");

    Route::get('/thank-you', [PaymentController::class, 'thankyou'])->name("thank-you");

    //if chose wrong tariff
    Route::get('change-tariff', [PaymentController::class, 'changeTariff'])->name("change-tariff");


    Route::post('subscribe', [MailChimpController::class, 'subscribe'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name("subscribe");


    Route::group(['middleware' => ['auth']], function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name("dashboard");

    });

    Route::get('{slug}', [SiteController::class, 'page'])->name("page");
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


