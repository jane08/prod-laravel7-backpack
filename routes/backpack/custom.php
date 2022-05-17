<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use App\Http\Controllers\Admin\StaticTransCrudController;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        (array) config('backpack.base.custom_admin', 'customAdmin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('menu-item', 'MenuItemCrudController');

    Route::crud('static-trans', 'StaticTransCrudController');

    Route::crud('review', 'ReviewCrudController');

    Route::get('/static-trans/pages',  [StaticTransCrudController::class, 'pages']);
    Route::crud('tariff', 'TariffCrudController');

    Route::crud('static-file', 'StaticFileCrudController');
    Route::crud('benefit', 'BenefitCrudController');

    Route::crud('gallery', 'GalleryCrudController');
    Route::crud('seo', 'SeoCrudController');

    Route::crud('contact', 'ContactCrudController');

    Route::crud('transaction', 'TransactionCrudController');

}); // this should be the absolute last line of this file
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        (array) config('backpack.base.teacher', 'teacher')
    // (array) config('backpack.base.custom_admin', 'customAdmin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('article', 'ArticleCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('tag', 'TagCrudController');


}); // this should be the absolute last line of this file
