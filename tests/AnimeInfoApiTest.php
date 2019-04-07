<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeAnimeInfoTrait;
use Tests\ApiTestTrait;

class AnimeInfoApiTest extends TestCase
{
    use MakeAnimeInfoTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_anime_info()
    {
        $animeInfo = $this->fakeAnimeInfoData();
        $this->response = $this->json('POST', '/api/animeInfos', $animeInfo);

        $this->assertApiResponse($animeInfo);
    }

    /**
     * @test
     */
    public function test_read_anime_info()
    {
        $animeInfo = $this->makeAnimeInfo();
        $this->response = $this->json('GET', '/api/animeInfos/'.$animeInfo->id);

        $this->assertApiResponse($animeInfo->toArray());
    }

    /**
     * @test
     */
    public function test_update_anime_info()
    {
        $animeInfo = $this->makeAnimeInfo();
        $editedAnimeInfo = $this->fakeAnimeInfoData();

        $this->response = $this->json('PUT', '/api/animeInfos/'.$animeInfo->id, $editedAnimeInfo);

        $this->assertApiResponse($editedAnimeInfo);
    }

    /**
     * @test
     */
    public function test_delete_anime_info()
    {
        $animeInfo = $this->makeAnimeInfo();
        $this->response = $this->json('DELETE', '/api/animeInfos/'.$animeInfo->id);

        $this->assertApiSuccess();
        $this->response = $this->json('GET', '/api/animeInfos/'.$animeInfo->id);

        $this->response->assertStatus(404);
    }
}
