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
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

Route::get('/', function (Request $request) {
    return view('index');
});

Route::post('login/getToken', function (Request $request) {
    $data = [];

    $qlurk = new Qlurk\ApiClient(env('PLURK_CONSUMER_KEY'), env('PLURK_CONSUMER_SECRET'));
    $oauth = new Qlurk\Oauth($qlurk);

    $r = $oauth->getRequestToken();

    if ($r) {
        $data['r'] = $r;
    }

    $token = $r['oauth_token'];
    $tokenSecret = $r['oauth_token_secret'];

    return response()->json(['data' => $data], 200);
});

Route::post('login/access_token', function (Request $request) {
    //
    $data = [];
    if ($request->has('oauth_verifier')
        && $request->has('oauth_token')
        && $request->has('oauth_token_secret')
    ) {
        $qlurk = new Qlurk\ApiClient(env('PLURK_CONSUMER_KEY'), env('PLURK_CONSUMER_SECRET'));
        $oauth = new Qlurk\Oauth($qlurk);

        $verifier = $request->oauth_verifier;
        $token = $request->oauth_token;
        $tokenSecret =  $request->oauth_token_secret;

        $r = $oauth->getAccessToken($verifier, $token, $tokenSecret);
        $resp = $qlurk->call('/APP/Users/me');

        $data = [
            'user' => $resp,
            'r'    => $r
        ];
    }

    return response()->json(['data' => $data], 200);
});

// routes/web.php
Route::post('/deploy', function () {
    $path = base_path();
    $token = config('key');
    $json = json_decode(file_get_contents('php://input'), true);

    if (empty($json['token']) || $json['token'] !== $token) {
        exit('error request');
    }

    $cmd = "cd $path && git pull";
    shell_exec($cmd);
});

Route::any('/{all}', function () {
    return view('index');
})->where(['all' => '.*']);
