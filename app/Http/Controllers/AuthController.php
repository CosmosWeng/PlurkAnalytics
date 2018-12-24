<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Qlurk;
use App\Models\User;

class AuthController extends Controller
{
    //

    public function getToken(Request $request)
    {
        $data = [];

        $qlurk = new Qlurk\ApiClient(env('PLURK_CONSUMER_KEY'), env('PLURK_CONSUMER_SECRET'));
        $oauth = new Qlurk\Oauth($qlurk);

        $r = $oauth->getRequestToken();

        if ($r) {
            $data['r'] = $r;
        }

        $token       = $r['oauth_token'];
        $tokenSecret = $r['oauth_token_secret'];

        return response()->json(['data' => $data], 200);
    }

    public function getAccessToken(Request $request)
    {
        $data = [];
        if ($request->has('oauth_verifier')
                && $request->has('oauth_token')
                && $request->has('oauth_token_secret')
        ) {
            $qlurk = new Qlurk\ApiClient(env('PLURK_CONSUMER_KEY'), env('PLURK_CONSUMER_SECRET'));
            $oauth = new Qlurk\Oauth($qlurk);

            $verifier    = $request->oauth_verifier;
            $token       = $request->oauth_token;
            $tokenSecret =  $request->oauth_token_secret;

            $r    = $oauth->getAccessToken($verifier, $token, $tokenSecret);
            $resp = $qlurk->call('/APP/Users/me');

            $data = [
                'user' => $resp,
                'r'    => $r
            ];

            $user = $this->syncUserInfo($resp);
            $this->updateToken($user->user_id, $r['oauth_token'], $r['oauth_token_secret']);
        }

        return response()->json(['data' => $data], 200);
    }

    public function syncUserInfo($user)
    {
        $user_orm = User::where('user_id', $user['id'])->first();

        if (! $user_orm) {
            $user_orm = User::create([
                'user_id'      => $user['id'],
                'privacy'      => $user['privacy'],
            ]);
        }

        return $user_orm;
    }

    public function updateToken($id, $token, $secret)
    {
        $user         = User::where('user_id', $id)->first();
        $user->token  = $token;
        $user->secret = $secret;
        $user->save();
    }
}
