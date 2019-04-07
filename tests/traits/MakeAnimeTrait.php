<?php namespace Tests\Traits;

use Faker\Factory as Faker;
use App\Models\Anime;
use App\Repositories\AnimeRepository;

trait MakeAnimeTrait
{
    /**
     * Create fake instance of Anime and save it in database
     *
     * @param array $animeFields
     * @return Anime
     */
    public function makeAnime($animeFields = [])
    {
        /** @var AnimeRepository $animeRepo */
        $animeRepo = \App::make(AnimeRepository::class);
        $theme = $this->fakeAnimeData($animeFields);
        return $animeRepo->create($theme);
    }

    /**
     * Get fake instance of Anime
     *
     * @param array $animeFields
     * @return Anime
     */
    public function fakeAnime($animeFields = [])
    {
        return new Anime($this->fakeAnimeData($animeFields));
    }

    /**
     * Get fake data of Anime
     *
     * @param array $animeFields
     * @return array
     */
    public function fakeAnimeData($animeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'serie_code' => $fake->word,
            'year' => $fake->randomDigitNotNull,
            'type' => $fake->word,
            'aired_text' => $fake->word,
            'aired_start' => $fake->date('Y-m-d H:i:s'),
            'aired_end' => $fake->date('Y-m-d H:i:s'),
            'episode' => $fake->randomDigitNotNull,
            'comment' => $fake->text
        ], $animeFields);
    }
}
