<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PlurkAPIRequest;
use App\Repositories\PlurkRepository;
use App\Libraries\PlurkAPI;
use App\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\PlurkBotMission;

class PlurkController extends AppBaseController
{
    public function __construct(PlurkAPIRequest $request, PlurkRepository $plurkRepository)
    {
        $this->plurkRepository  = $plurkRepository;
        $this->qlurk            = new PlurkAPI($request->get('_user'));
    }

    public function getPlurkResponsesByPlurkID(PlurkAPIRequest $request)
    {
        $user = $request->get('_user');
        $resp = $this->qlurk->call('/APP/Responses/get', [
            'plurk_id'      => $request->get('plurk_id'),
            'from_response' => 0
        ]);

        $friends            = $resp['friends'];
        $resp['responses']  = array_map(function ($value) use ($friends) {
            $value['user'] = $friends[$value['user_id']];

            return $value;
        }, $resp['responses']);

        return response()->json([
            'code' => 200,
            'data' => $resp['responses']
        ], 200);
    }

    public function getUsersMe(PlurkAPIRequest $request)
    {
        $resp          = $this->qlurk->call('/APP/Users/me');
        $user          = $request->get('_user');
        $resp['roles'] = $user->roles;//array_pluck($user->roles, 'name');

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

    public function index(PlurkAPIRequest $request)
    {
        $uuid = $request->plurk_uuid;
        $this->plurkRepository->pushCriteria(new RequestCriteria($request));

        $mission    = PlurkBotMission::where('code', 'DiceGameResultJob')->first();
        $mission_id = $mission->id;
        $data       = $this->plurkRepository->scopeQuery(function ($query) use ($uuid,$mission_id) {
            // return $query->where('user_id', $uuid)->orderBy('id', 'desc');
            return $query->Join('plurk_bot_plurk_mission', 'plurks.plurk_id', '=', 'plurk_bot_plurk_mission.plurk_id')
                        ->where('mission_id', $mission_id)
                        ->orderBy('plurks.id', 'desc');
        })->paginate($request->get('limit', null), $columns = ['*']);

        return $this->sendPaginateResponse($data->toArray(), 'Plurk retrieved successfully');
    }
}
