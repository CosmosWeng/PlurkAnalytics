<?php

namespace App\Console\Commands\Anime;

use Illuminate\Console\Command;
use App\Models\Cache;
use App\Models\Anime;
use App\Models\AnimeInfo;
use DiDom\Document;

class initList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anime:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Anime List from Cache';

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
        // $cache = Cache::where('code', 'Anime_2010A')->first();
        // $this->parse($cache->json);

        $caches   = Cache::all();
        $bar      = $this->output->createProgressBar(count($caches));
        foreach ($caches as $cache) {
            $this->parse($cache->json);
            $bar->advance();
        }
        $bar->finish();
        $this->line('Finish');
    }

    public function parse($json)
    {
        $json     = json_decode($json, true)['parse'];
        $content  = $json['text'];
        $document = new Document($content);

        $animes     = [];
        $year       = 0;
        $type_index = 0;
        $types      = [null, 'winter', 'spring', 'summer', 'fall'];
        $output     = $document->find('.mw-parser-output')[0];

        $children = $output->children();
        $bar      = $this->output->createProgressBar(count($children));
        foreach ($children as $post) {
            if ($post->isElementNode()) {
                if ($post->tag === 'h2') {
                    $year       = substr($post->text(), 0, 4);
                    $type_index = 0;
                }

                if ($post->tag === 'h3') {
                    ++$type_index;
                }

                if ($post->matches('table.wikitable') && $year) {
                    $trs   = $post->find('tr');
                    foreach ($trs as $index => $tr) {
                        if ($index) {
                            list($tmp, $aired_text, $title, $producers, $broadcast, $episode) =  explode(PHP_EOL, $tr->text());

                            if (! empty($episode) && (strpos($episode, '全') !== false && strpos($episode, '話') !== false)) {
                                $episode = substr($episode, strpos($episode, '全') + strlen('全'), strpos($episode, '話') - strlen('話'));
                                $episode = preg_replace('/\D/', '', $episode);
                            } else {
                                $episode = null;
                            }

                            $anime   = [
                                'serie_code' => '000000',
                                'year'       => $year,
                                'type'       => $types[$type_index],
                                'aired_text' => $aired_text,
                                'episode'    => empty($episode) ? null : $episode,
                            ];

                            $href = urldecode($tr->find('a')[0]->href);
                            if (! preg_match('/^\/wiki/', $href, $match)) {
                                $href = null;
                            }

                            $anime = Anime::create($anime);
                            AnimeInfo::create([
                                'anime_id'  => $anime->id,
                                'lang_id'   => 3,
                                'title'     => $title,
                                // 'synopsis'  => '',
                                'producers' => $producers,
                                // 'director'  => '',
                                // 'author'    => '',
                                'wiki_source' => $href,
                            ]);
                        }
                    }
                }
            }
            $bar->advance();
        }
    }
}
