<?php

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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => true,
]);

Route::post('uploads/file', 'UploadsController@uploadFile');


    Route::group(['prefix' => 'courses', 'namespace' => 'Api'], function () {
        Route::get('/', 'CourseController@index');
        Route::post('/', 'CourseController@store');
        Route::put('edit/{id}', 'CourseController@update');
        Route::get('delete/{id}', 'CourseController@destroy');
    });
    
    Route::group(['prefix' => 'subscriptions', 'namespace' => 'Api'], function () {
        Route::get('/', 'SubscriptionProductsController@index');
        Route::post('/', 'SubscriptionProductsController@store');
        Route::put('edit/{id}', 'CourseController@update');
        Route::get('delete/{id}', 'CourseController@destroy');
    });

    Route::group(['prefix' => 'authors', 'namespace' => 'Api'], function () {
        Route::get('/', 'AuthorsController@index');
        Route::post('/', 'AuthorsController@store');
        Route::put('edit/{id}', 'AuthorsController@update');
        Route::get('delete/{id}', 'AuthorsController@destroy');
    });


Route::middleware(['auth', 'verified'])->namespace('Web')->group(function () {
    Route::get('/', 'DashboardController@index')->name('home');
    // Route::group(['prefix' => 'courses'], function () {
    //     Route::get('/', 'CourseController@index');
    //     Route::post('/', 'CourseController@store');
    //     Route::put('edit/{id}', 'CourseController@update');
    //     Route::get('delete/{id}', 'CourseController@destroy');
    // });
    
    Route::group(['prefix' => 'profile'], function () {
        Route::post('edit/{profile}', 'ProfileController@update')->name('profile.update');
    });

    Route::group(['prefix' => 'user-info', 'namespace' => 'UserManagement'], function () {
        Route::get('/', 'UserController@userinfo')->name('userinfo.index');

        Route::get('json', 'UserController@userinfo')->name('userinfo.json');
    });


    Route::group(['prefix' => 'maintenance-log', 'namespace' => 'Maintenance'], function () {
        Route::get('/', 'MaintenanceLogController@index')->name('maintenance-log.index');

        Route::get('json', 'MaintenanceLogController@index')->name('maintenance-log.json');
    });

    Route::group(['prefix' => 'user-group', 'namespace' => 'UserManagement'], function () {
        Route::get('/', 'UserGroupController@index')->name('user-group.index');

        Route::get('json', 'UserGroupController@index')->name('user-group.json');

        // CREATE
        Route::post('create', 'UserGroupController@store')->name('user-group.store');

        // UPDATE
        Route::get('edit/{id}', 'UserGroupController@edit')->name('user-group.edit');
        Route::post('edit/{id}', 'UserGroupController@update')->name('user-group.update');

        // DELETE
        Route::get('delete/{id}', 'UserGroupController@destroy')->name('user-group.destroy');
    });


    Route::group(['prefix' => 'roles-management', 'namespace' => 'UserManagement'], function () {
        Route::get('/', 'RolesController@index')->name('roles.index');

        Route::get('json', 'RolesController@index')->name('roles.json');

        // VIEW
        Route::get('view/{id}', 'RolesController@show')->name('roles.view');
        Route::get('show/{id}', 'RolesController@getPermissions')->name('roles.show');
        Route::post('create', 'RolesController@store')->name('roles.store');

        // UPDATE
        Route::get('edit/{id}', 'RolesController@edit')->name('roles.edit');
        Route::put('edit/{id}', 'RolesController@update')->name('roles.update');

        // DELETE
        Route::get('delete/{id}', 'RolesController@destroy')->name('roles.destroy');
    });


    Route::group(['prefix' => 'permission-management', 'namespace' => 'UserManagement'], function () {
        Route::get('/', 'PermissionController@index')->name('roles.index');

        Route::get('json', 'PermissionController@index')->name('roles.json');

        // VIEW
        Route::get('view/{id}', 'PermissionController@show')->name('roles.view');
        Route::post('create', 'PermissionController@store')->name('roles.store');
        Route::get('show/{id}', 'PermissionController@getPermissions')->name('roles.show');

        // UPDATE
        Route::get('edit/{id}', 'PermissionController@edit')->name('roles.edit');
        Route::put('edit/{id}', 'PermissionController@update')->name('roles.update');

        // DELETE
        Route::get('delete/{id}', 'PermissionController@destroy')->name('roles.destroy');
    });
  

    Route::middleware(['role:SuperAdmin'] || ['role:Admin'])->group(function () {
        Route::group(['prefix' => 'user', 'namespace' => 'UserManagement'], function () {
            Route::get('/', 'UserController@index')->name('user.index');

            Route::get('json', 'UserController@index')->name('user.json');

            // VIEW
            Route::get('view/{user}', 'UserController@show')->name('user.view');

            // CREATE
            Route::get('create', 'UserController@create')->name('user.create');
            Route::post('create', 'UserController@store')->name('user.store');

            // UPDATE
            Route::get('edit/{user}', 'UserController@edit')->name('user.edit');
            Route::post('edit/{user}', 'UserController@update')->name('user.update');

            // DELETE
            Route::get('delete/{user}', 'UserController@destroy')->name('user.destroy');
        });
    });
});
