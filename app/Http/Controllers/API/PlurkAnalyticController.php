<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlurkAPIRequest;
use App\Libraries\PlurkAPI;

class PlurkAnalyticController extends Controller
{
    public function __construct(PlurkAPIRequest $request)
    {
        $this->qlurk = new PlurkAPI($request->get('_user'));
    }

    public function getReportAll(PlurkAPIRequest $request)
    {
        $plurks           = $this->qlurk->getPlurkByFilter('my');
        $user             = [
            'favorer' => 0,
            'replurk' => 0,
        ];

        $users            = [];
        $favorite_count   = 0;
        $replurkers_count = 0;
        $response_count   = 0;

        foreach ($plurks as $plurk) {
            //
            $favorite_count += $plurk['favorite_count'];
            $replurkers_count += $plurk['replurkers_count'];
            $response_count += $plurk['response_count'];
            //

            if ($plurk['favorers'] && count($plurk['favorers']) > 0) {
                foreach ($plurk['favorers'] as $user_id) {
                    if (! isset($users[$user_id])) {
                        $users[$user_id] = $user;
                    }

                    $users[$user_id]['favorer'] += 1;
                }
            }

            if ($plurk['replurkers'] && count($plurk['replurkers']) > 0) {
                foreach ($plurk['replurkers'] as $user_id) {
                    if (! isset($users[$user_id])) {
                        $users[$user_id] = $user;
                    }
                    $users[$user_id]['replurk'] += 1;
                }
            }
        }
        $data =  [
            'users'            => $users,
            'favorite_count'   => $favorite_count,
            'replurkers_count' => $replurkers_count,
            'response_count'   => $response_count
        ];

        return response()->json([
            'code' => 200,
            'data' => $data
        ], 200);
    }
}
