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

Route::view('/', 'index');

use Illuminate\Http\Request;

Route::get('error_bag', function (Request $request) {
    $validatedData = $request->validate([
        'passwoed'              => 'required|confirmed',
        // 'passwoed_confirmation' => 'required',
    ]);

    dd($validatedData);
});

Route::group(['prefix' => 'api/login'], function () {
    Route::post('getToken', 'AuthController@getToken');
    Route::post('accessToken', 'AuthController@getAccessToken');
});

Route::view('/{all}', 'index')->where(['all' => '.*']);

// Route::any('/{all}', function () {
//     return view('index');
// })->where(['all' => '.*']);
