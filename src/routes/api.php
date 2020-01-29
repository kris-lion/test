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

        Route::namespace('Category\Unit')->group(function () {
            Route::get('/units', 'UnitController@get');
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
            Route::namespace('Item')->prefix('/items')->group(function () {
                Route::get('/', 'ItemController@get');
                Route::get('/count', 'ItemController@count');
            });

            Route::namespace('Item')->prefix('/item')->group(function () {
                Route::post('/', 'ItemController@post');
                Route::put('/{id}', 'ItemController@put');
                Route::delete('/{id}', 'ItemController@delete');
            });
        });

        Route::group(['middleware' => ['permission:category']], function () {
            Route::get('/categories', 'Category\CategoryController@get');

            Route::namespace('Category')->prefix('/category')->group(function () {
                Route::post('/', 'CategoryController@post');
                Route::put('/{id}', 'CategoryController@put');
                Route::delete('/{id}', 'CategoryController@delete');

                Route::get('/attribute/types', 'Attribute\TypeController@get');
            });
        });
    });
});
