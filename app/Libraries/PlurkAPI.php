<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Qlurk\ApiClient;
use App\Exceptions\UserErrorException;

class PlurkAPI extends ApiClient
{
    public function __construct(Request $request)
    {
        parent::__construct(
            env('PLURK_CONSUMER_KEY'),
            env('PLURK_CONSUMER_SECRET')
        );

        if ($request->get('_user')) {
            $user = $request->get('_user');
            $this->setAccessToken($user->plurkUser->token, $user->plurkUser->secret);
        } else {
            throw new UserErrorException('USER_NOT_FOUND');
        }
    }

    public function getMyPlurkByMinTime($offset = '')
    {
        $minTime = time() - (24 * 3600 * 356) ;
        $plurks  = [];

        $resp = $this->call('/APP/Timeline/getPlurks', [
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
                $plurks = array_merge($plurks, $this->getMyPlurkByMinTime($offset));
            }
        }

        return $plurks;
    }
}
