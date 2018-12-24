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
Route::get('/', function () {
    return view('index');
});

// routes/web.php
// Route::post('/deploy', function (Request $request) {
//     $path = base_path();
//     $sig_check = 'sha1='.hash_hmac('sha1', $request->getContent(), config('app.key'));
//     $x_hub_signature = $request->header('X-Hub-Signature');
//     $agent = $request->header('User-Agent');

//     if (preg_match('/GitHub/i', $agent) && ! $x_hub_signature || $x_hub_signature !== $sig_check) {
//         return response()->json(['data' => ['token' => $sig_check, 'signature' => $x_hub_signature], 'message' => 'error request'], 500);
//     }

//     Artisan::call('deploy');
//     $output = Artisan::output();

//     return response()->json(['data' => ['output' => $output], 'message' => 'Success'], 200);
// });

Route::any('/{all}', function () {
    return view('index');
})->where(['all' => '.*']);
