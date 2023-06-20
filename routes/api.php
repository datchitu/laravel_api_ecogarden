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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('auth/login','ApiAuthController@login');
    Route::post('auth/register','ApiAuthController@register');
    Route::post('auth/forgot-password','ApiAuthController@forgotPassword');
    Route::post('auth/reset-password','ApiAuthController@resetPassword');
    Route::post('auth/info','ApiAuthController@info')->middleware('auth:api');
    Route::post('auth/social/{social}','ApiAuthController@loginSocial');
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'category'], function (){
        Route::get('','ApiCategoryController@index');
        Route::get('show/{id}','ApiCategoryController@show');
        Route::get('show-slug/{slug}','ApiCategoryController@showBySlug');
    });
    Route::group(['prefix' => 'product'], function (){
        Route::get('','ApiProductController@index');
        Route::get('show/{id}','ApiProductController@show');
        Route::get('show-slug/{slug}','ApiProductController@showBySlug');
    });

    Route::group(['prefix' => 'user'], function (){
        Route::put('update-info','ApiUserController@update')->middleware('auth:api'); 
        Route::put('update-password','ApiUserController@updatePassword')->middleware('auth:api');
    });
    Route::group(['prefix' => 'upload'], function (){
        Route::post('image','ApiUploadController@uploadImage')->middleware('auth:api');
    });

    Route::group(['prefix' => 'order'], function (){
        Route::get('','ApiOrderController@index');
        Route::get('config','ApiOrderController@getConfig');
        Route::get('show/{id}','ApiOrderController@show');
        Route::post('add','ApiOrderController@add');
        Route::put('update-cancel-paid','ApiOrderController@cancelStatusPaid');
        Route::put('update-paid/{id}','ApiOrderController@updateStatusPaid');
    });
});
