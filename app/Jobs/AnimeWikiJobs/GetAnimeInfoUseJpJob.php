<?php

namespace App\Jobs\AnimeWikiJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use DiDom\Document;
use App\Utils\Util;
use App\Models\Anime;
use App\Models\AnimeInfo;

class GetAnimeInfoUseJpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $anime;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Anime $anime)
    {
        //

        $this->anime  = $anime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $infos = $this->anime->infos;
        $info  = array_first($infos, function ($value, $key) {
            return $value['lang_id'] == 3;
        });

        $page = preg_replace('/^\/wiki\//', '', $info['wiki_source']) ;

        try {
            $response = $this->client($page);
            $contents = $response->getBody()->getContents();
            $contents = json_decode($contents);
            //
            if (! isset($contents->error)) {
                //
                $text = $contents->parse->text;
                $data = $this->parser($text);

                if (isset($data['is_redirect']) && $data['is_redirect']) {
                    $info->wiki_source = $data['is_redirect'];
                    $info->save();
                    //
                    $anime = Anime::find($this->anime->id)->first();
                    $this->dispatch($anime);
                    $this->fail('wait retry: '.Util::JsonEncode($info->toArray()));

                    return ;
                }

                if (isset($data['not_infobox']) && $data['not_infobox']) {
                    $this->fail('is notinfobox: '.Util::JsonEncode($info->toArray()));
                    $this->delete();

                    return ;
                }

                // Update Info Data Form Wiki
                $info->synopsis  = $data['synopsis'];
                $info->director  = $data['director'];
                $info->author    = $data['author'];
                $info->producers = $data['producers'];

                $info->save();

                // Get Other Lang Uir
                $langlinks = $contents->parse->langlinks;
                $zh        = array_first($langlinks, function ($value, $key) {
                    return $value->lang == 'zh';
                });

                if ($zh) {
                    $title = Util::OpenccConvert($zh->title);
                    $href  = urldecode(parse_url($zh->url, PHP_URL_PATH));

                    $animeInfoUseZh = AnimeInfo::where([
                        ['lang_id', 2],
                        ['anime_id', $info->anime_id]
                    ]);

                    $animeInfoCount = $animeInfoUseZh->count();
                    if ($animeInfoCount == 0) {
                        AnimeInfo::create([
                            'anime_id'    => $this->anime->id,
                            'lang_id'     => 2,
                            'title'       => $title,
                            'wiki_source' => $href
                        ]);
                    } else {
                        $animeInfoUseZh = $animeInfoUseZh->first();

                        $animeInfoUseZh->title       = $title;
                        $animeInfoUseZh->wiki_source = $href;
                        $animeInfoUseZh->save();
                    }
                }
            }

            //
        } catch (ClientException $e) {
            echo Psr7\str($e->getRequest());
            echo Psr7\str($e->getResponse());
        }
    }

    public function parser($text)
    {
        list($author, $director, $producers) = '';

        $document   = new Document($text);
        $output     = $document->find('.mw-parser-output')[0];

        $redirectMsg = $output->first('.redirectMsg');
        if ($redirectMsg) {
            $href  = $output->first('a')->href;

            return ['is_redirect' => urldecode(parse_url($href, PHP_URL_PATH))];
        }

        $infobox = $output->first('table.infobox');
        if (! $infobox) {
            return ['not_infobox' => true];
        }

        foreach ($infobox->find('tr') as $tr) {
            if ($tr->first('th') && $tr->first('td')) {
                //
                $thText = trim($tr->first('th')->text());
                if ($thText == '原作') {
                    $author = $tr->first('td')->text();
                }

                if ($thText == '監督') {
                    $director = $tr->first('td')->text();
                }

                if ($thText == '製作') {
                    $producers = $tr->first('td')->text();
                }
            }
        }

        return [
            'synopsis'  => $output->first('p')->text(),
            'director'  => trim($director),
            'author'    => trim($author),
            'producers' => trim($producers),
        ];
    }

    public function client($page = '')
    {
        $client = new Client();

        return $client->request(
            'GET',
            'https://jp.wikipedia.org/w/api.php',
            [
                'query'    => [
                    'action'        => 'parse',
                    'utf8'          => true,
                    'format'        => 'json',
                    'formatversion' => 2,
                    'page'          => $page,
                ]
            ]
        );
    }
}
