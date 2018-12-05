<?php

Route::group(['middleware' => 'custom', 'prefix' => '/v1/category', 'namespace' => 'Modules\API\Http\Controllers'], function () {
    Route::get('/', [
        'uses' => 'CategoryController@list',
    ]);
    Route::get('/list', [
        'uses' => 'CategoryController@list',
    ]);
    Route::get('/detail/{id}', [
        'uses' => 'CategoryController@detail',
    ]);
    Route::post('/create', [
        'uses' => 'CategoryController@create',
    ]);
    Route::put('/update/{id}', [
        'uses' => 'CategoryController@update',
    ]);
    Route::delete('/delete/{id}', [
        'uses' => 'CategoryController@delete',
    ]);
});

Route::group(['middleware' => 'custom', 'prefix' => '/v1/user', 'namespace' => 'Modules\API\Http\Controllers'], function () {
    Route::get('/', [
        'uses' => 'UserController@list',
    ]);
    Route::get('/list', [
        'uses' => 'UserController@list',
    ]);
    Route::get('/detail/{id}', [
        'uses' => 'UserController@detail',
    ]);
    Route::post('/register', [
        'uses' => 'UserController@register',
    ]);
    Route::put('/update/{id}', [
        'uses' => 'UserController@update',
    ]);
    Route::delete('/delete/{id}', [
        'uses' => 'UserController@delete',
    ]);
    Route::post('/login', [
        'uses' => 'UserController@login',
    ]);
    Route::get('/info', [
        'uses' => 'UserController@info',
    ]);
});

Route::group(['middleware' => 'custom', 'prefix' => '/v1/product', 'namespace' => 'Modules\API\Http\Controllers'], function () {
    Route::get('/', [
        'uses' => 'ProductController@list',
    ]);
    Route::get('/list', [
        'uses' => 'ProductController@list',
    ]);
    Route::get('/detail/{id}', [
        'uses' => 'ProductController@detail',
    ]);
    Route::post('/create', [
        'uses' => 'ProductController@create',
    ]);
});


