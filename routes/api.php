<?php

use Illuminate\Support\Facades\Route;
use Shopper\Framework\Http\Controllers\Api\CategoryController;

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

Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
    Route::get('/sizes', 'ShopSizeController@index')->name('sizes');
    Route::post('/initialization', 'ShopController@store')->name('initialization');
    Route::put('/setting', 'ShopController@updateSetting')->name('update.setting');
});

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/managers', 'UserController@index')->name('managers');
});

Route::post('/upload', 'MediaController@upload')->name('upload');
Route::delete('/remove-file/{id}', 'MediaController@remove')->name('remove');

Route::middleware(config('shopper.middleware_api'))->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
});
