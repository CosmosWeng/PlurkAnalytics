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

Route::group(['middleware' => ['auth.token']], function () {
    //
    Route::group(['prefix' => 'plurk'], function () {
        Route::get('getFriends', 'PlurkController@getFriendsCompletion');
        Route::get('getFriendsByOffset', 'PlurkController@getFriendsByOffset');
        Route::get('getMe', 'PlurkController@getUsersMe');
    });

    //
    Route::group(['prefix' => 'analyse'], function () {
        Route::get('report', 'PlurkAnalyticController@getReportAll');
    });
});

use App\Models\User;

Route::get('getMe', function () {
    $user = User::with(['roles'])->find(1);
    $user->setUserRole(['user']);

    return response()->json([
        'code' => 200,
        'data' => $user
    ], 200);
});
Route::resource('messages', 'MessageAPIController');
