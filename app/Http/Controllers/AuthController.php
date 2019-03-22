<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Qlurk;
use App\Models\User;
use App\Models\PlurkUser;

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

        // $token       = $r['oauth_token'];
        // $tokenSecret = $r['oauth_token_secret'];

        return response()->json(['code' => 200, 'data' => $data], 200);
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

            // $r = $oauth->getAccessToken($verifier, $token, $tokenSecret);
            $r = $oauth->getAccessToken($verifier, $token, $tokenSecret);

            $resp = $qlurk->call('/APP/Users/me');

            if ($resp) {
                // create Plurk_User
                $puser  = PlurkUser::find($resp['id']);

                if (! $puser) {
                    $puser = PlurkUser::create([
                        'uuid'         => $resp['id'],
                        'nick_name'    => $resp['nick_name'],
                        'display_name' => $resp['display_name'],
                        'privacy'      => $resp['privacy'],
                        'token'        => $r['oauth_token'],
                        'secret'       => $r['oauth_token_secret'],
                    ]);
                } else {
                    $puser->display_name = $resp['display_name'];
                    $puser->token        = $r['oauth_token'];
                    $puser->secret       = $r['oauth_token_secret'];
                    $puser->save();
                }

                // Create User
                $user = $puser->user;
                if (! $user) {
                    $user = User::create([
                        'name'      => $resp['display_name'],
                        'email'     => $this->restToken('user', 30),
                        'password'  => $r['oauth_token_secret'],
                        'api_token' => $this->restToken('api', 30),
                    ]);

                    // Set Role
                    $user->setUserRole(['user']);

                    //
                    $puser->user_id = $user->id;
                    $puser->save();
                } else {
                    $user->api_token = $this->restToken('api', 30);
                    $user->save();
                }
            }

            $data = [
                'user'  => $resp,
                'token' => $user->api_token
            ];
        }

        return response()->json(['code' => 200, 'data' => $data], 200);
    }

    public function restToken($guard, $day = 30, $str_n = 10)
    {
        $time  = time();
        $token = [
            'random' => str_random($str_n),
            'guard'  => $guard,
            'time'   => $time + (3600 * 24 * $day)
        ];
        $token = implode('@@', $token);
        $token = encrypt($token);

        return $token;
    }
}
