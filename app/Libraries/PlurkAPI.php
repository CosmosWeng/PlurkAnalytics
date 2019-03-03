<?php

namespace App\Libraries;

use App\Models\User;
use App\Models\PlurkApiLog;
use Qlurk\ApiClient;
use App\Exceptions\UserErrorException;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlurkAPI extends ApiClient
{
    private $user = null;

    public function __construct(User $user = null)
    {
        parent::__construct(
            env('PLURK_CONSUMER_KEY'),
            env('PLURK_CONSUMER_SECRET')
        );

        if ($user) {
            $this->user = $user;
            $this->setAccessToken($user->plurkUser->token, $user->plurkUser->secret);
        } else {
            throw new UserErrorException('USER_NOT_FOUND');
        }
    }

    public function call($path, $params = [])
    {
        try {
            $resp = parent::call($path, $params);

            PlurkApiLog::create([
                'code'     => 200,
                'params'   => $params,
                'method'   => 'GET',
                'path'     => $path,
                'own_id'   => $this->user->id,
                'own_type' => 'api',
                'response' => $resp
            ]);
        } catch (\Throwable $th) {
            //
            PlurkApiLog::create([
                'code'     => $th->getCode(),
                'params'   => $params,
                'method'   => 'GET',
                'path'     => $path,
                'own_id'   => $this->user->id,
                'own_type' => 'api',
                'response' => $th->getMessage()
            ]);

            throw new HttpResponseException(response()->json([
                'code'    => 600001,
                'message' => 'PLURK API ERROR'
            ]));
        }

        return $resp;
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
