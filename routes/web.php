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

/** Social login routes **/
Route::get('auth/{provider}', 'Auth\SocialLoginController@redirectToProvider')
    ->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback')
    ->name('social.login.callback');
Route::get('auth/enter/email', 'Auth\SocialLoginController@enterEmail')
    ->name('social.enter_email');
Route::post('auth/enter/email', 'Auth\SocialLoginController@enterEmailPost')
    ->name('social.enter_email_post');

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::get('profile', 'App\Profile\ProfileController@index')->name('profile');
    Route::get('wallets', 'App\Wallet\WalletController@index')->name('wallet');
    Route::get('orders', 'App\Order\OrderController@index')->name('order');
    Route::get('locations', 'App\Location\LocationController@index')->name('location');
    Route::get('categories', 'App\Category\CategoryController@index')->name('category');
});
