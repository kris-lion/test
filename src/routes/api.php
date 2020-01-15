<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {
    Route::namespace('Auth')->prefix('/auth')->group(function () {
        Route::post('/login', 'LoginController@post');

        Route::group(['middleware' => ['token']], function () {
            Route::get('/logout', 'LogoutController@get');
        });
    });

    Route::namespace('Account')->prefix('/account')->group(function () {
        Route::group(['middleware' => ['token']], function () {
            Route::get('/', 'AccountController@get');
        });
    });
});
