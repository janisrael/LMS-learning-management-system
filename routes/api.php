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
Route::group(['prefix'=>'check','namespace'=>'Api'], function(){
    Route::get('check', 'MaintenanceController@check');
});


Route::group(['prefix' => 'chapters', 'namespace' => 'Api'], function () {
    Route::apiResource('/', 'ChapterController');
});
// Route::group(['middleware'=>'auth:api'], function(){
Route::group(['prefix' => 'test/', 'namespace' => 'Api'], function () {
    Route::apiResource('lessons', 'LessonController');
});
// });
Route::post('uploads/file', 'UploadsController@uploadFile');



    Route::group(['prefix' => 'are/', 'namespace' => 'Api'], function () {
        Route::get('courses', 'CourseController@index');
        Route::middleware('auth:api')->get('/all', 'CourseController@index');
    });

Route::group(['middleware'=>'auth:api'], function(){
    Route::group(['prefix' => 'new/','namespace'=>'Auth'], function () {
        Route::get('logind', 'LoginController@shakoy');
    });
   
    Route::get('keep-alive', function(){return date("Y-m-d H:i:s");});

    Route::group(['prefix'=>'api/v1/','namespace'=>'Web\Marketing'], function(){
        Route::apiResource('everwebinar', 'EverWebinarController@shit');
    });

    Route::group(['prefix'=>'users','namespace'=>'Web'], function(){
        Route::apiResource('user', 'MaintenanceManagementController');
    });

    Route::group(['prefix' => 'user-info','namespace'=>'Web\UserManagement'], function () {
        Route::get('user-info', 'UserController@userinfo');
    });

    Route::group(['prefix' => 'roles-management','namespace'=>'Web\UserManagement'], function () {
        Route::apiResource('roles-management', 'RolesController@index');
    });

    Route::group(['prefix' => 'login','namespace'=>'Auth'], function () {
        Route::get('/', 'LoginController@credentials');
    });

    Route::group(['prefix'=>'user-group','namespace'=>'Web'], function(){
        Route::apiResource('user-group', 'UserGroupController');
    });

    Route::group(['prefix'=>'profile','namespace'=>'Web'], function(){
        Route::apiResource('profile', 'ProfileController');
    });

});




