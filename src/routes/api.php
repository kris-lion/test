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

    Route::group(['middleware' => ['token']], function () {
        Route::group(['middleware' => ['permission:role']], function () {
            Route::namespace('User\Auth')->group(function () {
                Route::prefix('/user')->group(function () {
                    Route::get('/roles', 'RoleController@get');
                    Route::prefix('/role')->group(function () {
                        Route::post('/', 'RoleController@post');
                        Route::put('/{id}', 'RoleController@put');
                        Route::delete('/{id}', 'RoleController@delete');

                        Route::get('/permissions', 'PermissionController@get');
                    });
                });
            });
        });

        Route::group(['middleware' => ['permission:user']], function () {
            Route::get('/users', 'User\UserController@get');

            Route::namespace('User')->prefix('/user')->group(function () {
                Route::post('/', 'UserController@post');
                Route::put('/{id}', 'UserController@put');
                Route::delete('/{id}', 'UserController@delete');
            });
        });

        Route::group(['middleware' => ['permission:reference']], function () {
            Route::get('/products', 'Product\ProductController@get');
        });

        Route::group(['middleware' => ['permission:reference_category']], function () {
            Route::get('/product/categories', 'Product\CategoryController@get');
        });
    });
});
