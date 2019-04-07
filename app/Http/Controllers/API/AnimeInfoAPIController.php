<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimeInfoAPIRequest;
use App\Http\Requests\API\UpdateAnimeInfoAPIRequest;
use App\Models\AnimeInfo;
use App\Repositories\AnimeInfoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AnimeInfoController
 * @package App\Http\Controllers\API
 */

class AnimeInfoAPIController extends AppBaseController
{
    /** @var  AnimeInfoRepository */
    private $animeInfoRepository;

    public function __construct(AnimeInfoRepository $animeInfoRepo)
    {
        $this->animeInfoRepository = $animeInfoRepo;
    }

    /**
     * Display a listing of the AnimeInfo.
     * GET|HEAD /animeInfos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->animeInfoRepository->pushCriteria(new RequestCriteria($request));
        $this->animeInfoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $animeInfos = $this->animeInfoRepository->all();

        return $this->sendResponse($animeInfos->toArray(), 'Anime Infos retrieved successfully');
    }

    /**
     * Store a newly created AnimeInfo in storage.
     * POST /animeInfos
     *
     * @param CreateAnimeInfoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimeInfoAPIRequest $request)
    {
        $input = $request->all();

        $animeInfo = $this->animeInfoRepository->create($input);

        return $this->sendResponse($animeInfo->toArray(), 'Anime Info saved successfully');
    }

    /**
     * Display the specified AnimeInfo.
     * GET|HEAD /animeInfos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AnimeInfo $animeInfo */
        $animeInfo = $this->animeInfoRepository->findWithoutFail($id);

        if (empty($animeInfo)) {
            return $this->sendError('Anime Info not found');
        }

        return $this->sendResponse($animeInfo->toArray(), 'Anime Info retrieved successfully');
    }

    /**
     * Update the specified AnimeInfo in storage.
     * PUT/PATCH /animeInfos/{id}
     *
     * @param  int $id
     * @param UpdateAnimeInfoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimeInfoAPIRequest $request)
    {
        $input = $request->all();

        /** @var AnimeInfo $animeInfo */
        $animeInfo = $this->animeInfoRepository->findWithoutFail($id);

        if (empty($animeInfo)) {
            return $this->sendError('Anime Info not found');
        }

        $animeInfo = $this->animeInfoRepository->update($input, $id);

        return $this->sendResponse($animeInfo->toArray(), 'AnimeInfo updated successfully');
    }

    /**
     * Remove the specified AnimeInfo from storage.
     * DELETE /animeInfos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AnimeInfo $animeInfo */
        $animeInfo = $this->animeInfoRepository->findWithoutFail($id);

        if (empty($animeInfo)) {
            return $this->sendError('Anime Info not found');
        }

        $animeInfo->delete();

        return $this->sendResponse($id, 'Anime Info deleted successfully');
    }
}
