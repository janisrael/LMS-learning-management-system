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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Users
Route::post('uploads/file', 'UploadsController@uploadFile');

Route::prefix('/user')->group( function() {
    Route::post('/login', 'api\v1\LoginController@login');
    
    Route::middleware('auth:api')->get('/logout', 'api\v1\AuthController@logout')->name('logout');
    Route::middleware('auth:api')->get('/auth', 'api\v1\UserContoller@index')->name('auth');
    
});
Route::group(['middleware'=>'auth:api'], function(){
    Route::group(['prefix' => 'courses','namespace'=>'api\v1'], function () {
        Route::get('/', 'CourseController@index');
        Route::post('/', 'CourseController@store');
        Route::put('edit/{id}', 'CourseController@update');
        Route::get('delete/{id}', 'CourseController@destroy');
        
    });

    Route::group(['prefix' => 'subscriptions','namespace'=>'api\v1'], function () {
        Route::get('/', 'SubscriptionProductsController@index');
        Route::post('/', 'SubscriptionProductsController@store');
        Route::put('edit/{id}', 'SubscriptionProductsController@update');
        Route::get('delete/{id}', 'SubscriptionProductsController@destroy');
    });

    Route::group(['prefix' => 'lessons','namespace'=>'api\v1'], function () {
        Route::get('/', 'LessonController@index');
        Route::post('/', 'LessonController@store');
        Route::put('edit/{id}', 'LessonController@update');
        Route::get('delete/{id}', 'LessonController@destroy');
    });

    Route::group(['prefix' => 'chapters','namespace'=>'api\v1'], function () {
        Route::get('/', 'ChapterController@index');
        Route::post('/', 'ChapterController@store');
        Route::put('edit/{id}', 'ChapterController@update');
        Route::get('delete/{id}', 'ChapterController@destroy');
        Route::get('lessons', 'ChapterController@getlesson');
    });

    Route::group(['prefix' => 'authors','namespace'=>'api\v1'], function () {
        Route::get('/', 'AuthorController@index');
        Route::post('/', 'AuthorController@store');
        Route::put('edit/{id}', 'AuthorController@update');
        Route::get('delete/{id}', 'AuthorController@destroy');
    });

    Route::group(['prefix' => 'category','namespace'=>'api\v1'], function () {
        Route::get('/', 'CategoryController@index');
        Route::post('/', 'CategoryController@store');
        Route::put('edit/{id}', 'CategoryController@update');
        Route::get('delete/{id}', 'CategoryController@destroy');
    });
});
// Route::prefix(['/courses' => 'api/v1/' => 'namespace'])->group( function() {
//     Route::get('/', 'CourseController@index');
//     Route::post('/', 'CourseController@store');
//     Route::put('edit/{id}', 'CourseController@update');
//     Route::get('delete/{id}', 'CourseController@destroy');
// });