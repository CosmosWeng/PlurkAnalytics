<?php namespace Tests\Traits;

use Faker\Factory as Faker;
use App\Models\AnimeInfo;
use App\Repositories\AnimeInfoRepository;

trait MakeAnimeInfoTrait
{
    /**
     * Create fake instance of AnimeInfo and save it in database
     *
     * @param array $animeInfoFields
     * @return AnimeInfo
     */
    public function makeAnimeInfo($animeInfoFields = [])
    {
        /** @var AnimeInfoRepository $animeInfoRepo */
        $animeInfoRepo = \App::make(AnimeInfoRepository::class);
        $theme = $this->fakeAnimeInfoData($animeInfoFields);
        return $animeInfoRepo->create($theme);
    }

    /**
     * Get fake instance of AnimeInfo
     *
     * @param array $animeInfoFields
     * @return AnimeInfo
     */
    public function fakeAnimeInfo($animeInfoFields = [])
    {
        return new AnimeInfo($this->fakeAnimeInfoData($animeInfoFields));
    }

    /**
     * Get fake data of AnimeInfo
     *
     * @param array $animeInfoFields
     * @return array
     */
    public function fakeAnimeInfoData($animeInfoFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'anime_id' => $fake->randomDigitNotNull,
            'lang_id' => $fake->randomDigitNotNull,
            'title' => $fake->word,
            'synopsis' => $fake->text,
            'producers' => $fake->word,
            'director' => $fake->word,
            'author' => $fake->word,
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'created_at' => $fake->date('Y-m-d H:i:s')
        ], $animeInfoFields);
    }
}
