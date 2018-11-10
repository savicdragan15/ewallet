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


Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', 'App\Profile\ProfileController@index')->name('profile');
    Route::get('/wallet', 'App\Wallet\WalletController@index')->name('wallet');

});



//Route::group(['prefix' => 'api/v1', 'as' => 'api.v1.', 'namespace' => 'Api\V1'], function () {
//
//    Route::resource('profile', 'ProfileController');
//    Route::resource('wallet', 'WalletController');
//    Route::resource('walletType', 'WalletTypeController');
//
//});
