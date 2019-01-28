<?php

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
    Route::resource('wallets', 'WalletController');
    Route::resource('orders', 'OrderController');
//    Route::resource('markets', 'MarketController');
//    Route::resource('locations', 'LocationController');
    Route::resource('categories', 'CategoryController');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('getNumberOfOrdersCurrentMonth', 'DashboardController@getNumberOfOrdersCurrentMonth')
            ->name('all_orders_current_month');
        Route::get('getNumberOfOrders', 'DashboardController@getNumberOfOrders')->name('all_orders');
        Route::get('getSpentMoneyCurrentMonth', 'DashboardController@getSpentMoneyCurrentMonth')
            ->name('get_spent_money_current_month');
        Route::get('getSpentMoney', 'DashboardController@getSpentMoney')->name('get_spent_money');
        Route::get('getLatestOrders', 'DashboardController@getLatestOrders')->name('get_latest_orders');
        Route::get('getSumOrdersByMonth', 'DashboardController@getSumOrdersByMonth')->name('get_sum_orders_by_month');
    });
});


Route::post('admin/auth/login', 'Auth\ApiAuthController@login');

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'admin/auth'
], function () {
    Route::post('logout', 'Auth\ApiAuthController@logout');
    Route::post('refresh', 'Auth\ApiAuthController@refresh');
    Route::post('me', 'Auth\ApiAuthController@me');
});

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'admin',
    'namespace' => 'Api\Admin'
], function () {
    Route::resource('users', 'UserController');
});
