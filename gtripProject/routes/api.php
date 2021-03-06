<?php

use Illuminate\Http\Request;
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

Route::prefix('auth')->group(function () {
    Route::post('register', 'Auth\AuthController@register')->name('register');
    Route::post('login', 'Auth\AuthController@login')->name('login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', 'Auth\AuthController@user');
        Route::post('/logout', 'Auth\AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', 'Auth\AuthController@user');
    Route::get('/user/destinationdata', 'DestinationDetailsController@show');
    Route::post('/user/destinationdata', 'DestinationDetailsController@store');
    Route::delete('/user/destinationdata/{id}', 'DestinationDetailsController@destroy');
    Route::get('/user/destinationdata/{id}', 'DestinationDetailsController@singleItem');
    Route::post('/user/destinationdata/{id}/enableddisable',  'DestinationDetailsController@enableDisableDestination');
    
    Route::post('/user/destinationdata/{id}/destroykey',  'searchKeysController@destroy');
    
    Route::post('/user/destinationdata/{id}/addkey',  'searchKeysController@addKey');

});
