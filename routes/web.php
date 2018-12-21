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
Route::post('/deploy', function (Request $request) {
    $path = base_path();

    $sig_check = 'sha1='.hash_hmac('sha1', Request::getContent(), config('app.key'));
    $x_hub_signature = $request->header('X-Hub-Signature');

    if ($x_hub_signature || $x_hub_signature !== $sig_check) {
        return response()->json(['data' => ['token' => $sig_check, 'signature' => $x_hub_signature], 'message' => 'error request'], 500);
    }

    $cmd = "cd $path && git checkout . && git pull";
    $result = shell_exec($cmd);

    return response()->json(['data' => ['cmd' => $cmd], 'message' => 'Success'], 200);
});

Route::any('/{all}', function () {
    return view('index');
})->where(['all' => '.*']);
