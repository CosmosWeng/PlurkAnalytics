<?php namespace Tests\Repositories;

use App\Models\Anime;
use App\Repositories\AnimeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeAnimeTrait;
use Tests\ApiTestTrait;

class AnimeRepositoryTest extends TestCase
{
    use MakeAnimeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnimeRepository
     */
    protected $animeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->animeRepo = \App::make(AnimeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_anime()
    {
        $anime = $this->fakeAnimeData();
        $createdAnime = $this->animeRepo->create($anime);
        $createdAnime = $createdAnime->toArray();
        $this->assertArrayHasKey('id', $createdAnime);
        $this->assertNotNull($createdAnime['id'], 'Created Anime must have id specified');
        $this->assertNotNull(Anime::find($createdAnime['id']), 'Anime with given id must be in DB');
        $this->assertModelData($anime, $createdAnime);
    }

    /**
     * @test read
     */
    public function test_read_anime()
    {
        $anime = $this->makeAnime();
        $dbAnime = $this->animeRepo->find($anime->id);
        $dbAnime = $dbAnime->toArray();
        $this->assertModelData($anime->toArray(), $dbAnime);
    }

    /**
     * @test update
     */
    public function test_update_anime()
    {
        $anime = $this->makeAnime();
        $fakeAnime = $this->fakeAnimeData();
        $updatedAnime = $this->animeRepo->update($fakeAnime, $anime->id);
        $this->assertModelData($fakeAnime, $updatedAnime->toArray());
        $dbAnime = $this->animeRepo->find($anime->id);
        $this->assertModelData($fakeAnime, $dbAnime->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_anime()
    {
        $anime = $this->makeAnime();
        $resp = $this->animeRepo->delete($anime->id);
        $this->assertTrue($resp);
        $this->assertNull(Anime::find($anime->id), 'Anime should not exist in DB');
    }
}
