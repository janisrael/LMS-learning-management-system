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

Route::get('/', function () {
    return view('home');
});


Route::post('/logout', function () {
    return view('home');
});
Route::get('home', 'web\HomeController@index')->name('home');
Auth::routes();

// Route::get('/', 'web\HomeController@index')->name('home');

// Route::middleware(['auth', 'verified'])->namespace('web')->group(function () {
//     Route::get('/home', 'HomeController@index')->name('login');
// });