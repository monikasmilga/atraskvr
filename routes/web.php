<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'categories_translations'], function () {

        Route::get('/', ['as' => 'app.categories_translations.index','uses' => 'VRCategoriesTranslationsController@adminIndex']);

        Route::get('/create', ['as' => 'app.categories_translations.create','uses' => 'VRCategoriesTranslationsController@adminCreate']);
        Route::post('/create', ['as' => 'app.categories_translations.store', 'uses' => 'VRCategoriesTranslationsController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.categories_translations.edit', 'uses' => 'VRCategoriesTranslationsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.categories_translations.update', 'uses' => 'VRCategoriesTranslationsController@adminUpdate']);

            Route::get('/', ['as' => 'app.categories_translations.show', 'uses' => 'VRCategoriesTranslationsController@adminShow']);
            Route::delete('/', ['as' => 'app.categories_translations.delete', 'uses' => 'VRCategoriesTranslationsController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'languages'], function () {

        Route::get('/', ['as' => 'app.languages.index','uses' => 'VRLanguagesController@adminIndex']);

        Route::get('/create', ['as' => 'app.languages.create','uses' => 'VRLanguagesController@adminCreate']);
        Route::post('/create', ['as' => 'app.languages.store', 'uses' => 'VRLanguagesController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.languages.edit', 'uses' => 'VRLanguagesController@adminEdit']);
            Route::post('/edit', ['as' => 'app.languages.update', 'uses' => 'VRLanguagesController@adminUpdate']);

            Route::get('/', ['as' => 'app.languages.show', 'uses' => 'VRLanguagesController@adminShow']);
            Route::delete('/', ['as' => 'app.languages.delete', 'uses' => 'VRLanguagesController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'menu'], function () {

        Route::get('/', ['as' => 'app.menu.index','uses' => 'VRMenuController@adminIndex']);

        Route::get('/create', ['as' => 'app.menu.create','uses' => 'VRMenuController@adminCreate']);
        Route::post('/create', ['as' => 'app.menu.store', 'uses' => 'VRMenuController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.menu.edit', 'uses' => 'VRMenuController@adminEdit']);
            Route::post('/edit', ['as' => 'app.menu.update', 'uses' => 'VRMenuController@adminUpdate']);

            Route::get('/', ['as' => 'app.menu.show', 'uses' => 'VRMenuController@adminShow']);
            Route::delete('/', ['as' => 'app.menu.delete', 'uses' => 'VRMenuController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'menu_translations'], function () {

        Route::get('/', ['as' => 'app.menu_translations.index','uses' => 'VRMenuTranslationsController@adminIndex']);

        Route::get('/create', ['as' => 'app.menu_translations.create','uses' => 'VRMenuTranslationsController@adminCreate']);
        Route::post('/create', ['as' => 'app.menu_translations.store', 'uses' => 'VRMenuTranslationsController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.menu_translations.edit', 'uses' => 'VRMenuTranslationsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.menu_translations.update', 'uses' => 'VRMenuTranslationsController@adminUpdate']);

            Route::get('/', ['as' => 'app.menu_translations.show', 'uses' => 'VRMenuTranslationsController@adminShow']);
            Route::delete('/', ['as' => 'app.menu_translations.delete', 'uses' => 'VRMenuTranslationsController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'orders'], function () {

        Route::get('/', ['as' => 'app.orders.index','uses' => 'VROrdersController@adminIndex']);

        Route::get('/create', ['as' => 'app.orders.create','uses' => 'VROrdersController@adminCreate']);
        Route::post('/create', ['as' => 'app.orders.store', 'uses' => 'VROrdersController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.orders.edit', 'uses' => 'VROrdersController@adminEdit']);
            Route::post('/edit', ['as' => 'app.orders.update', 'uses' => 'VROrdersController@adminUpdate']);

            Route::get('/', ['as' => 'app.orders.show', 'uses' => 'VROrdersController@adminShow']);
            Route::delete('/', ['as' => 'app.orders.delete', 'uses' => 'VROrdersController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'pages'], function () {

        Route::get('/', ['as' => 'app.pages.index','uses' => 'VRPagesController@adminIndex']);

        Route::get('/create', ['as' => 'app.pages.create','uses' => 'VRPagesController@adminCreate']);
        Route::post('/create', ['as' => 'app.pages.store', 'uses' => 'VRPagesController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.pages.edit', 'uses' => 'VRPagesController@adminEdit']);
            Route::post('/edit', ['as' => 'app.pages.update', 'uses' => 'VRPagesController@adminUpdate']);

            Route::get('/', ['as' => 'app.pages.show', 'uses' => 'VRPagesController@adminShow']);
            Route::delete('/', ['as' => 'app.pages.delete', 'uses' => 'VRPagesController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'pages_categories'], function () {

        Route::get('/', ['as' => 'app.pages_categories.index','uses' => 'VRPagesCategoriesController@adminIndex']);

        Route::get('/create', ['as' => 'app.pages_categories.create','uses' => 'VRPagesCategoriesController@adminCreate']);
        Route::post('/create', ['as' => 'app.pages_categories.store', 'uses' => 'VRPagesCategoriesController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.pages_categories.edit', 'uses' => 'VRPagesCategoriesController@adminEdit']);
            Route::post('/edit', ['as' => 'app.pages_categories.update', 'uses' => 'VRPagesCategoriesController@adminUpdate']);

            Route::get('/', ['as' => 'app.pages_categories.show', 'uses' => 'VRPagesCategoriesController@adminShow']);
            Route::delete('/', ['as' => 'app.pages_categories.delete', 'uses' => 'VRPagesCategoriesController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'pages_translations'], function () {

        Route::get('/', ['as' => 'app.pages_translations.index','uses' => 'VRPagesTranslationsController@adminIndex']);

        Route::get('/create', ['as' => 'app.pages_translations.create','uses' => 'VRPagesTranslationsController@adminCreate']);
        Route::post('/create', ['as' => 'app.pages_translations.store', 'uses' => 'VRPagesTranslationsController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.pages_translations.edit', 'uses' => 'VRPagesTranslationsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.pages_translations.update', 'uses' => 'VRPagesTranslationsController@adminUpdate']);

            Route::get('/', ['as' => 'app.pages_translations.show', 'uses' => 'VRPagesTranslationsController@adminShow']);
            Route::delete('/', ['as' => 'app.pages_translations.delete', 'uses' => 'VRPagesTranslationsController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'permissions'], function () {

        Route::get('/', ['as' => 'app.permissions.index','uses' => 'VRPermissionsController@adminIndex']);

        Route::get('/create', ['as' => 'app.permissions.create','uses' => 'VRPermissionsController@adminCreate']);
        Route::post('/create', ['as' => 'app.permissions.store', 'uses' => 'VRPermissionsController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.permissions.edit', 'uses' => 'VRPermissionsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.permissions.update', 'uses' => 'VRPermissionsController@adminUpdate']);

            Route::get('/', ['as' => 'app.permissions.show', 'uses' => 'VRPermissionsController@adminShow']);
            Route::delete('/', ['as' => 'app.permissions.delete', 'uses' => 'VRPermissionsController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'reservations'], function () {

        Route::get('/', ['as' => 'app.reservations.index','uses' => 'VRReservationsController@adminIndex']);

        Route::get('/create', ['as' => 'app.reservations.create','uses' => 'VRReservationsController@adminCreate']);
        Route::post('/create', ['as' => 'app.reservations.store', 'uses' => 'VRReservationsController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.reservations.edit', 'uses' => 'VRReservationsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.reservations.update', 'uses' => 'VRReservationsController@adminUpdate']);

            Route::get('/', ['as' => 'app.reservations.show', 'uses' => 'VRReservationsController@adminShow']);
            Route::delete('/', ['as' => 'app.reservations.delete', 'uses' => 'VRReservationsController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'resources'], function () {

        Route::get('/', ['as' => 'app.resources.index','uses' => 'VRResourcesController@adminIndex']);

        Route::get('/create', ['as' => 'app.resources.create','uses' => 'VRResourcesController@adminCreate']);
        Route::post('/create', ['as' => 'app.resources.store', 'uses' => 'VRResourcesController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.resources.edit', 'uses' => 'VRResourcesController@adminEdit']);
            Route::post('/edit', ['as' => 'app.resources.update', 'uses' => 'VRResourcesController@adminUpdate']);

            Route::get('/', ['as' => 'app.resources.show', 'uses' => 'VRResourcesController@adminShow']);
            Route::delete('/', ['as' => 'app.resources.delete', 'uses' => 'VRResourcesController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', ['as' => 'app.users.index','uses' => 'VRUsersController@adminIndex']);

        Route::get('/create', ['as' => 'app.users.create','uses' => 'VRUsersController@adminCreate']);
        Route::post('/create', ['as' => 'app.users.store', 'uses' => 'VRUsersController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.users.edit', 'uses' => 'VRUsersController@adminEdit']);
            Route::post('/edit', ['as' => 'app.users.update', 'uses' => 'VRUsersController@adminUpdate']);

            Route::get('/', ['as' => 'app.users.show', 'uses' => 'VRUsersController@adminShow']);
            Route::delete('/', ['as' => 'app.users.delete', 'uses' => 'VRUsersController@adminDestroy']);

        });
    });

});