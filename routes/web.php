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

use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function () {
        return view('admin.welcome_admin');
    });

    Route::group(['prefix' => 'pages_categories_translations'], function () {

        Route::get('/', ['as' => 'app.pages_categories_translations.index','uses' => 'VRPagesCategoriesTranslationsController@adminIndex']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/create', ['as' => 'app.pages_categories_translations.create','uses' => 'VRPagesCategoriesTranslationsController@adminCreate']);
            Route::post('/create', ['as' => 'app.pages_categories_translations.store', 'uses' => 'VRPagesCategoriesTranslationsController@adminStore']);

            Route::get('/edit', ['as' => 'app.pages_categories_translations.edit', 'uses' => 'VRPagesCategoriesTranslationsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.pages_categories_translations.update', 'uses' => 'VRPagesCategoriesTranslationsController@adminUpdate']);

            Route::get('/', ['as' => 'app.pages_categories_translations.show', 'uses' => 'VRPagesCategoriesTranslationsController@adminShow']);
            Route::delete('/', ['as' => 'app.pages_categories_translations.delete', 'uses' => 'VRPagesCategoriesTranslationsController@adminDestroy']);

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

    Route::group(['prefix' => 'menus'], function () {

        Route::get('/', ['as' => 'app.menus.index','uses' => 'VRMenusController@adminIndex']);

        Route::get('/create', ['as' => 'app.menus.create','uses' => 'VRMenusController@adminCreate']);
        Route::post('/create', ['as' => 'app.menus.store', 'uses' => 'VRMenusController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.menus.edit', 'uses' => 'VRMenusController@adminEdit']);
            Route::post('/edit', ['as' => 'app.menus.update', 'uses' => 'VRMenusController@adminUpdate']);

            Route::get('/', ['as' => 'app.menus.show', 'uses' => 'VRMenusController@adminShow']);
            Route::delete('/', ['as' => 'app.menus.delete', 'uses' => 'VRMenusController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'menus_translations'], function () {

        Route::get('/', ['as' => 'app.menus_translations.index','uses' => 'VRMenusTranslationsController@adminIndex']);

        Route::get('/create', ['as' => 'app.menus_translations.create','uses' => 'VRMenusTranslationsController@adminCreate']);
        Route::post('/create', ['as' => 'app.menus_translations.store', 'uses' => 'VRMenusTranslationsController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/create', ['as' => 'app.menus_translations.create','uses' => 'VRMenusTranslationsController@adminCreate']);
            Route::post('/create', ['as' => 'app.menus_translations.store', 'uses' => 'VRMenusTranslationsController@adminStore']);

            Route::get('/edit', ['as' => 'app.menus_translations.edit', 'uses' => 'VRMenusTranslationsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.menus_translations.update', 'uses' => 'VRMenusTranslationsController@adminUpdate']);

            Route::get('/', ['as' => 'app.menus_translations.show', 'uses' => 'VRMenusTranslationsController@adminShow']);
            Route::delete('/', ['as' => 'app.menus_translations.delete', 'uses' => 'VRMenusTranslationsController@adminDestroy']);

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

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/create', ['as' => 'app.pages_translations.create','uses' => 'VRPagesTranslationsController@adminCreate']);
            Route::post('/create', ['as' => 'app.pages_translations.store', 'uses' => 'VRPagesTranslationsController@adminStore']);

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

    Route::group(['prefix' => 'roles'], function () {

        Route::get('/', ['as' => 'app.roles.index','uses' => 'VRRolesController@adminIndex']);

        Route::get('/create', ['as' => 'app.roles.create','uses' => 'VRRolesController@adminCreate']);
        Route::post('/create', ['as' => 'app.roles.store', 'uses' => 'VRRolesController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.roles.edit', 'uses' => 'VRRolesController@adminEdit']);
            Route::post('/edit', ['as' => 'app.roles.update', 'uses' => 'VRRolesController@adminUpdate']);

            Route::get('/', ['as' => 'app.roles.show', 'uses' => 'VRRolesController@adminShow']);
            Route::delete('/', ['as' => 'app.roles.delete', 'uses' => 'VRRolesController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'reservations'], function () {

        Route::get('/', ['as' => 'app.reservations.index','uses' => 'VRReservationsController@adminIndex']);

        Route::get('/create/{date?}', ['as' => 'app.reservations.create','uses' => 'VRReservationsController@adminCreate']);
        Route::post('/create', ['as' => 'app.reservations.store', 'uses' => 'VRReservationsController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.reservations.edit', 'uses' => 'VRReservationsController@adminEdit']);
            Route::post('/edit', ['as' => 'app.reservations.update', 'uses' => 'VRReservationsController@adminUpdate']);

            Route::get('/', ['as' => 'app.reservations.show', 'uses' => 'VRReservationsController@adminShow']);
            Route::delete('/', ['as' => 'app.reservations.delete', 'uses' => 'VRReservationsController@adminDestroy']);

        });
    });

    Route::group(['prefix' => 'resources'], function () {

        Route::get('/', ['as' => 'app.resources.index','uses' => 'VRResourceController@adminIndex']);

        Route::get('/create', ['as' => 'app.resources.create','uses' => 'VRResourceController@adminCreate']);
        Route::post('/create', ['as' => 'app.resources.store', 'uses' => 'VRResourceController@adminStore']);

        Route::group(['prefix' => '{id}'], function () {

            Route::get('/edit', ['as' => 'app.resources.edit', 'uses' => 'VRResourceController@adminEdit']);
            Route::post('/edit', ['as' => 'app.resources.update', 'uses' => 'VRResourceController@adminUpdate']);

            Route::get('/', ['as' => 'app.resources.show', 'uses' => 'VRResourceController@adminShow']);
            Route::delete('/', ['as' => 'app.resources.delete', 'uses' => 'VRResourceController@adminDestroy']);

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




Route::group(['prefix' => '{language}', 'middleware' => ['check-language']],  function() {

    Route::get('/', [
        'as' => 'frontend.index',
        'uses' => 'FrontEndController@index'
    ]);

});





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
