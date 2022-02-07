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
});
// Route::prefix(['/courses' => 'api/v1/' => 'namespace'])->group( function() {
//     Route::get('/', 'CourseController@index');
//     Route::post('/', 'CourseController@store');
//     Route::put('edit/{id}', 'CourseController@update');
//     Route::get('delete/{id}', 'CourseController@destroy');
// });