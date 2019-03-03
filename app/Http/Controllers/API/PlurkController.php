<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlurkAPIRequest;
use App\Libraries\PlurkAPI;

class PlurkController extends Controller
{
    public function __construct(PlurkAPIRequest $request)
    {
        $this->qlurk = new PlurkAPI($request->get('_user'));
    }

    public function getUsersMe(PlurkAPIRequest $request)
    {
        $resp = $this->qlurk->call('/APP/Users/me');

        return response()->json([
            'code' => 200,
            'data' => $resp
        ], 200);
    }

    public function getFriendsByOffset(PlurkAPIRequest $request)
    {
        $page   = $request->get('page') - 1;
        $limit  = $request->get('limit');
        $params = [
            'user_id' => $request->get('plurk_uuid'),
            'offset'  => $page * $limit,
            'limit'   => $limit,
        ];
        $resp = $this->qlurk->call('/APP/FriendsFans/getFriendsByOffset', $params);

        return response()->json([
            'code' => 200,
            'data' => $resp
        ], 200);
    }

    public function getFriendsCompletion(PlurkAPIRequest $request)
    {
        $resp = $this->qlurk->call('/APP/FriendsFans/getCompletion');

        return response()->json([
            'code' => 200,
            'data' => $resp
        ], 200);
    }
}
