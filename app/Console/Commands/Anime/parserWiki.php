<?php

namespace App\Console\Commands\Anime;

use Illuminate\Console\Command;
use App\Models\Anime;
use App\Models\AnimeInfo;
use App\Utils\Util;
use App\Jobs\AnimeWikiJobs\GetAnimeInfoUseJpJob;
use App\Jobs\AnimeWikiJobs\GetAnimeInfoUseZhJob;

class parserWiki extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anime:parser {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lang = $this->argument('lang');

        if ($lang == 'en') {
            $this->getAnimeByEn();
        }

        if ($lang == 'zh') {
            $this->getAnimeByZh();
        }
    }

    public function getAnimeByZh()
    {
        $animes = Anime::Select('animes.*')
            ->leftJoin('anime_infos', function ($join) {
                $join->on('anime_infos.anime_id', '=', 'animes.id')
                    ->where('lang_id', 2);
            })
            ->whereNotNull('anime_infos.wiki_source')
            ->where('serie_code', '000000')
            // ->orderby('animes.id', 'desc')
            // ->take(1)
            ->get();

        // dd($animes, Util::getSqlLogs());
        $bar = $this->output->createProgressBar(count($animes));
        foreach ($animes as $anime) {
            GetAnimeInfoUseZhJob::dispatch($anime);
            $bar->advance();
        }
        $bar->finish();
        $this->line('Finish');
    }

    public function getAnimeByEn()
    {
        //
        $animes = Anime::Select('animes.*')
            ->leftJoin('anime_infos', 'anime_infos.anime_id', '=', 'animes.id')
            ->whereNotNull('anime_infos.wiki_source')
            ->where('serie_code', '000000')
            // ->orderby('animes.id', 'desc')
            // ->take(5)
            ->get();

        // dd($animes->toArray(), Util::getSqlLogs());
        $bar = $this->output->createProgressBar(count($animes));
        foreach ($animes as $index => $anime) {
            GetAnimeInfoUseJpJob::dispatch($anime);
            $bar->advance();
        }
        $bar->finish();
        $this->line('Finish');
    }
}
