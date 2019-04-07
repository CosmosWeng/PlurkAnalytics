<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeAnimeTrait;
use Tests\ApiTestTrait;

class AnimeApiTest extends TestCase
{
    use MakeAnimeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_anime()
    {
        $anime = $this->fakeAnimeData();
        $this->response = $this->json('POST', '/api/animes', $anime);

        $this->assertApiResponse($anime);
    }

    /**
     * @test
     */
    public function test_read_anime()
    {
        $anime = $this->makeAnime();
        $this->response = $this->json('GET', '/api/animes/'.$anime->id);

        $this->assertApiResponse($anime->toArray());
    }

    /**
     * @test
     */
    public function test_update_anime()
    {
        $anime = $this->makeAnime();
        $editedAnime = $this->fakeAnimeData();

        $this->response = $this->json('PUT', '/api/animes/'.$anime->id, $editedAnime);

        $this->assertApiResponse($editedAnime);
    }

    /**
     * @test
     */
    public function test_delete_anime()
    {
        $anime = $this->makeAnime();
        $this->response = $this->json('DELETE', '/api/animes/'.$anime->id);

        $this->assertApiSuccess();
        $this->response = $this->json('GET', '/api/animes/'.$anime->id);

        $this->response->assertStatus(404);
    }
}
