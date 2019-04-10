<?php

namespace App\Jobs\AnimeWikiJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use App\Libraries\WikiParsor;
use App\Utils\Util;
use App\Models\Anime;
use App\Models\AnimeInfo;

class GetAnimeInfoUseZhJob implements ShouldQueue
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
        $this->anime  = $anime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $infos = $this->anime->infos;
        $info  = array_first($infos, function ($value, $key) {
            return $value['lang_id'] == 2;
        });
        $page = preg_replace('/^\/wiki\//', '', $info['wiki_source']);
        try {
            $response = $this->client($page);
            $contents = $response->getBody()->getContents();

            $paeseWiki = new WikiParsor($contents);
            if ($paeseWiki->checkStatus()) {
                list($author, $director, $producers, $romanText) = '';

                $infobox = $paeseWiki->getInfoBox();
                foreach ($infobox->find('tr') as $tr) {
                    if ($tr->first('th') && $tr->first('td')) {
                        //
                        $thText = Util::OpenccConvert(trim($tr->first('th')->text()), 's2t.json');
                        //
                        if ($thText == '作者') {
                            $author = $tr->first('td')->text();
                        }

                        if ($thText == '導演') {
                            $director = $tr->first('td')->text();
                        }

                        if ($thText == '製作') {
                            $producers = $tr->first('td')->text();
                        }
                        //
                        if ($thText == '羅馬字') {
                            $romanText = $tr->first('td')->text();
                        }
                    }
                }
                $synopsis = $paeseWiki->getSynopsis();

                // dd($author, $director, $producers, snake_case($romanText), $synopsis);

                // Update Info Data Form Wiki
                $info->synopsis  = $synopsis;
                $info->director  = $director;
                $info->author    = $author;
                $info->producers = $producers;
                $info->save();
                //
                $this->anime->serie_code = snake_case($romanText);
                $this->anime->save();
            }
        } catch (ClientException $e) {
            echo Psr7\str($e->getRequest());
            echo Psr7\str($e->getResponse());
        } catch (Exception $e) {
            $this->fail($e->getMessage().': '.Util::JsonEncode($info->toArray()));

            return;
        }
    }

    public function client($page = '')
    {
        $client = new Client();

        return $client->request(
            'GET',
            'https://zh.wikipedia.org/w/api.php',
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
