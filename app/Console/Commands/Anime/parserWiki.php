<?php

namespace App\Console\Commands\Anime;

use Illuminate\Console\Command;
use App\Models\Anime;
use App\Models\AnimeInfo;
use App\Utils\Util;
use App\Jobs\AnimeWikiJobs\GetAnimeInfoUseJpJob;

class parserWiki extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anime:parser';

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
        //
        // $animes = Anime::whereIn('id', ['3501', '3821', '4131'])->get();
        // // dd($anime);
        // foreach ($animes as $anime) {
        //     GetAnimeInfoUseJpJob::dispatch($anime);
        // }
        // exit;

        //
        $animes = Anime::leftJoin('anime_infos', 'anime_infos.anime_id', '=', 'animes.id')
            ->whereNotNull('anime_infos.wiki_source')
            ->where('serie_code', '000000')
            // ->orderby('animes.id', 'desc')
            // ->take(5)
            ->get();

        // dd($animes->toArray(), Util::getSqlLogs());

        $bar = $this->output->createProgressBar(count($animes));
        foreach ($animes as $index => $anime) {
            GetAnimeInfoUseJpJob::dispatch($anime);
            if ($index > 10) {
                break;
            }
            $bar->advance();
        }
        $bar->finish();
        $this->line('Finish');
    }
}
