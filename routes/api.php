<?php

use Illuminate\Support\Facades\Route;

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

Route::namespace ('App\Http\Controllers\Api')->group(function () {

    Route::post('/oauth/login', 'AccessTokenController@login');

    Route::get('forbiddenError', 'AuthFailedController@forbiddenError')->name('forbiddenError');
    Route::post('forbiddenError', 'AuthFailedController@forbiddenError')->name('forbiddenError');

    Route::get('/test', 'TestController@testGet');
    Route::post('/test', 'TestController@testPost');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/users/logged-in-user', 'UsersController@getLoggedInUser');
        Route::get('/users', 'UsersController@getUsers');

        
        Route::get('/user-roles', 'UserRoleController@getUserRoles');
    });
});
