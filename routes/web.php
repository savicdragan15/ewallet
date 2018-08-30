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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'Profile\ProfileController@index')->name('profile');



Route::group(['namespace' => 'Api\V1', 'prefix' => 'api/v1', 'as' => 'api.v1.'], function () {

    Route::resource('profile', 'ProfileController');

});
