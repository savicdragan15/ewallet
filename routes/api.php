<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1', 'as' => 'api.v1.', 'namespace' => 'Api\V1'], function () {
    Route::resource('profile', 'ProfileController');
    Route::resource('wallet', 'WalletController');
    Route::resource('walletType', 'WalletTypeController');
    Route::resource('order', 'OrderController');
    Route::resource('markets', 'MarketController');
    Route::resource('location', 'LocationController');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('getNumberOfOrders', 'DashboardController@getNumberOfOrders')->name('all_orders');
    });
});
