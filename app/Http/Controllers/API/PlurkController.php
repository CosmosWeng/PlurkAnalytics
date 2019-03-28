<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PlurkAPIRequest;
use App\Repositories\PlurkRepository;
use App\Libraries\PlurkAPI;
use App\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;

class PlurkController extends AppBaseController
{
    public function __construct(PlurkAPIRequest $request, PlurkRepository $plurkRepository)
    {
        $this->plurkRepository  = $plurkRepository;
        $this->qlurk            = new PlurkAPI($request->get('_user'));
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
        $data = $this->plurkRepository->scopeQuery(function ($query) use ($uuid) {
            // return $query->where('user_id', $uuid)->orderBy('id', 'desc');
            return $query->orderBy('id', 'desc');
        })->paginate($request->get('limit', null), $columns = ['*']);

        return $this->sendPaginateResponse($data->toArray(), 'Plurk retrieved successfully');
    }
}
