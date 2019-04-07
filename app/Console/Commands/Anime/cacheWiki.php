<?php

namespace App\Console\Commands\Anime;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;

use App\Models\Cache;

class cacheWiki extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anime:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache Wiki List';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $yearList = [
            '1950-1960' => '日本のテレビアニメ作品一覧_(1950年代-1960年代)',
            '1970'      => '日本のテレビアニメ作品一覧_(1970年代)',
            '1980'      => '日本のテレビアニメ作品一覧_(1980年代)',
            '1990'      => '日本のテレビアニメ作品一覧_(1990年代)',
            '2000B'     => '日本のテレビアニメ作品一覧_(2000年代_前半)',
            '2000A'     => '日本のテレビアニメ作品一覧_(2000年代_後半)',
            '2010B'     => '日本のテレビアニメ作品一覧_(2010年代_前半)',
            '2010A'     => '日本のテレビアニメ作品一覧_(2010年代_後半)',
        ];

        $bar = $this->output->createProgressBar(count($yearList));
        foreach ($yearList as $code => $page) {
            try {
                $response = $this->client($page);
                $contents = $response->getBody()->getContents();

                Cache::create([
                    'timestamp' => time(),
                    'code'      => 'Anime_'.$code,
                    'json'      => $contents,
                    // 'comment'   => ''
                ]);
            } catch (ClientException $e) {
                echo Psr7\str($e->getRequest());
                echo Psr7\str($e->getResponse());
            }
            $bar->advance();
        }
        $bar->finish();
        $this->line('Finish');
    }

    public function client($page = '日本動畫列表_(2019年)')
    {
        return $this->client->request(
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
