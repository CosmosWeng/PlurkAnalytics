<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Qlurk\ApiClient;

class PlurkAPI extends ApiClient
{
    public function __construct(Request $request)
    {
        parent::__construct(
                env('PLURK_CONSUMER_KEY'),
                env('PLURK_CONSUMER_SECRET')
        );

        $user = $request->get('_user');
        $this->setAccessToken($user->plurkUser->token, $user->plurkUser->secret);

        // $this->qlurk = new Qlurk\ApiClient(
        //     env('PLURK_CONSUMER_KEY'),
        //     env('PLURK_CONSUMER_SECRET'),
        //     $user->plurkUser->token,
        //     $user->plurkUser->secret
        // );
    }
}
