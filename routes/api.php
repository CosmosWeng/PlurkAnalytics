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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'plurk'], function () {
    Route::get('getFriends', 'PlurkController@getFriendsCompletion');
    Route::get('getMe', 'PlurkController@getUsersMe');

    Route::get('getMePlurks', 'PlurkController@getMyPlurks');
});

Route::group(['prefix' => 'analyse'], function () {
    Route::get('report', 'PlurkAnalyticController@getReportAll');
});
