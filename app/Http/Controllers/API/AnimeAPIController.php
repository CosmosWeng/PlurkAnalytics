<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnimeAPIRequest;
use App\Http\Requests\API\UpdateAnimeAPIRequest;
use App\Models\Anime;
use App\Repositories\AnimeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AnimeController
 * @package App\Http\Controllers\API
 */

class AnimeAPIController extends AppBaseController
{
    /** @var  AnimeRepository */
    private $animeRepository;

    public function __construct(AnimeRepository $animeRepo)
    {
        $this->animeRepository = $animeRepo;
    }

    /**
     * Display a listing of the Anime.
     * GET|HEAD /animes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->animeRepository->pushCriteria(new RequestCriteria($request));
        $this->animeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $animes = $this->animeRepository->all();

        return $this->sendResponse($animes->toArray(), 'Animes retrieved successfully');
    }

    /**
     * Store a newly created Anime in storage.
     * POST /animes
     *
     * @param CreateAnimeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnimeAPIRequest $request)
    {
        $input = $request->all();

        $anime = $this->animeRepository->create($input);

        return $this->sendResponse($anime->toArray(), 'Anime saved successfully');
    }

    /**
     * Display the specified Anime.
     * GET|HEAD /animes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Anime $anime */
        $anime = $this->animeRepository->findWithoutFail($id);

        if (empty($anime)) {
            return $this->sendError('Anime not found');
        }

        return $this->sendResponse($anime->toArray(), 'Anime retrieved successfully');
    }

    /**
     * Update the specified Anime in storage.
     * PUT/PATCH /animes/{id}
     *
     * @param  int $id
     * @param UpdateAnimeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnimeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Anime $anime */
        $anime = $this->animeRepository->findWithoutFail($id);

        if (empty($anime)) {
            return $this->sendError('Anime not found');
        }

        $anime = $this->animeRepository->update($input, $id);

        return $this->sendResponse($anime->toArray(), 'Anime updated successfully');
    }

    /**
     * Remove the specified Anime from storage.
     * DELETE /animes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Anime $anime */
        $anime = $this->animeRepository->findWithoutFail($id);

        if (empty($anime)) {
            return $this->sendError('Anime not found');
        }

        $anime->delete();

        return $this->sendResponse($id, 'Anime deleted successfully');
    }
}
