<?php namespace Tests\Repositories;

use App\Models\AnimeInfo;
use App\Repositories\AnimeInfoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeAnimeInfoTrait;
use Tests\ApiTestTrait;

class AnimeInfoRepositoryTest extends TestCase
{
    use MakeAnimeInfoTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnimeInfoRepository
     */
    protected $animeInfoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->animeInfoRepo = \App::make(AnimeInfoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_anime_info()
    {
        $animeInfo = $this->fakeAnimeInfoData();
        $createdAnimeInfo = $this->animeInfoRepo->create($animeInfo);
        $createdAnimeInfo = $createdAnimeInfo->toArray();
        $this->assertArrayHasKey('id', $createdAnimeInfo);
        $this->assertNotNull($createdAnimeInfo['id'], 'Created AnimeInfo must have id specified');
        $this->assertNotNull(AnimeInfo::find($createdAnimeInfo['id']), 'AnimeInfo with given id must be in DB');
        $this->assertModelData($animeInfo, $createdAnimeInfo);
    }

    /**
     * @test read
     */
    public function test_read_anime_info()
    {
        $animeInfo = $this->makeAnimeInfo();
        $dbAnimeInfo = $this->animeInfoRepo->find($animeInfo->id);
        $dbAnimeInfo = $dbAnimeInfo->toArray();
        $this->assertModelData($animeInfo->toArray(), $dbAnimeInfo);
    }

    /**
     * @test update
     */
    public function test_update_anime_info()
    {
        $animeInfo = $this->makeAnimeInfo();
        $fakeAnimeInfo = $this->fakeAnimeInfoData();
        $updatedAnimeInfo = $this->animeInfoRepo->update($fakeAnimeInfo, $animeInfo->id);
        $this->assertModelData($fakeAnimeInfo, $updatedAnimeInfo->toArray());
        $dbAnimeInfo = $this->animeInfoRepo->find($animeInfo->id);
        $this->assertModelData($fakeAnimeInfo, $dbAnimeInfo->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_anime_info()
    {
        $animeInfo = $this->makeAnimeInfo();
        $resp = $this->animeInfoRepo->delete($animeInfo->id);
        $this->assertTrue($resp);
        $this->assertNull(AnimeInfo::find($animeInfo->id), 'AnimeInfo should not exist in DB');
    }
}
