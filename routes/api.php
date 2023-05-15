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

Route::post('register', 'API\RegisterController@register')->name('api.register');
Route::post('login', 'API\LoginController@login')->name('api.login');

Route::group(
    [
        'middleware' => 'auth:api'
    ],
    function() {
        Route::prefix('user')->group(function() {
            Route::get('/show', 'API\UserController@show')->name('api.user.show');
        });

        Route::resource('v1', 'API\Telco\TelcoV1Controller');
        Route::resource('v2', 'API\Telco\TelcoV2Controller');
    }
);
