<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlurkAPIRequest;
use Qlurk;

class PlurkController extends Controller
{
    public function __construct(PlurkAPIRequest $request)
    {
        $this->qlurk = new \Qlurk\ApiClient(
            env('PLURK_CONSUMER_KEY'),
            env('PLURK_CONSUMER_SECRET'),
            $request->oauth_token,
            $request->oauth_token_secret
        );
    }

    public function getUsersMe(PlurkAPIRequest $request)
    {
        $resp = $this->qlurk->call('/APP/Users/me');

        return response()->json([
            'code' => 200,
            'data' => $resp
        ], 200);
    }
    //
    public function getFriendsCompletion(PlurkAPIRequest $request)
    {
        $resp = $this->qlurk->call('/APP/FriendsFans/getCompletion');

        return response()->json([
            'code' => 200,
            'data' => $resp
        ], 200);
    }
}
