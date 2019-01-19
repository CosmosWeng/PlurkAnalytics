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

    public function getMyPlurks(PlurkAPIRequest $request)
    {
        $plurks = $this->myPlurks();

        return response()->json([
            'code' => 200,
            'data' => $plurks
        ], 200);
    }

    public function myPlurks($offset = '')
    {
        $minTime = time() - (24 * 3600 * 356) ;
        $plurks  = [];

        $resp   = $this->qlurk->call('/APP/Timeline/getPlurks', [
            'offset'            => $offset,
            'limit'             => 30,
            'filter'            => 'my',
            'favorers_detail'   => true,
            'limited_detail'    => true,
            'replurkers_detail' => true,
            'minimal_user'      => true
        ]);

        if ($resp['plurks'] && count($resp['plurks']) > 0) {
            $plurks  = array_where($resp['plurks'], function ($value, $key) use ($minTime) {
                return strtotime($value['posted']) > $minTime;
            });

            $firstlurk    = array_shift($resp['plurks']);
            $lastPlurk    = array_pop($resp['plurks']);

            if ($firstlurk['posted'] && count($plurks) > 0) {
                $offset = date('Y-m-d\TH:i:s', strtotime($lastPlurk['posted']));
                $plurks = array_merge($plurks, $this->myPlurks($offset));
            }
        }

        return $plurks;
    }
}
