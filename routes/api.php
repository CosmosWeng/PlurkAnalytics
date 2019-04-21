<?php

use Illuminate\Http\Request;
use App\Models\User;

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

Route::group(['middleware' => ['auth.token']], function () {
    //
    Route::group(['prefix' => 'plurk'], function () {
        Route::get('getFriends', 'PlurkController@getFriendsCompletion');
        Route::get('getFriendsByOffset', 'PlurkController@getFriendsByOffset');
        Route::get('getMe', 'PlurkController@getUsersMe');

        Route::get('response', 'PlurkController@getPlurkResponsesByPlurkID');
    });

    Route::get('plurk', 'PlurkController@index');

    //
    Route::group(['prefix' => 'analyse'], function () {
        Route::get('report', 'PlurkAnalyticController@getReportAll');
    });
});

Route::get('getMe', function () {
    $user = User::with(['roles'])->find(1);
    $user->setUserRole(['user']);
    //
    $user = $user->toArray();
    $user['roles'] = array_pluck($user['roles'], 'name');

    return response()->json([
        'code' => 200,
        'data' => $user
    ], 200);
});
Route::resource('messages', 'MessageAPIController');

Route::resource('animes', 'AnimeAPIController');
Route::resource('anime_infos', 'AnimeInfoAPIController');
