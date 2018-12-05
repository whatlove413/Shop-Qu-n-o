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

// Route::get('/', [

//     'as' => 'auth::getLogin',
//     'uses' => 'Auth\LoginController@login'
// ]);

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

/**
 * @todo: route auth
 */
Route::group(['middleware' => 'web', 'prefix' => 'auth'], function ()
{

    // hiện thị trang login
    Route::get('/login', [
        'as' => 'auth::login',
        'uses' => 'Auth\LoginController@login'
    ]);
    
    // xác nhận đăng nhập
    Route::post('/verify', [
        'as' => 'auth::verify',
        'uses' => 'Auth\LoginController@verify'
    ]);

    // đăng xuất
    Route::get('/logout', [
        'as' => 'auth::logout',
        'uses' => 'Auth\LoginController@logout'
    ]);
});