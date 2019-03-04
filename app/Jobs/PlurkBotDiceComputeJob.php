<?php

namespace App\Jobs;

use DB;
use App\Models\User;
use App\Models\PlurkBotMissionLog;
use App\Libraries\PlurkAPI;
use DiDom\Document;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PlurkBotDiceComputeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Init
        $botUser     = User::find(1);
        $this->qlurk = new PlurkAPI($botUser);

        // get Plurkd
        $plurks = DB::select('select * from plurks left join (select plurk_id as i ,mission_code from plurk_bot_mission_logs) as t1 ON plurks.plurk_id=t1.i where t1.mission_code = :mission_code ', ['mission_code' => 'one_dice']);

        foreach ($plurks as $plurk) {
            $users                                  = [];
            list($tagText, $diceText, $count)       = array_pad(explode(' ', $plurk->content_raw), 3, 1);
            $responses                              = $this->getResponsesById($plurk->plurk_id);

            if ($count && (int)$responses['response_count'] >= (int)$count) {
                try {
                    $log = PlurkBotMissionLog::Create([
                                'plurk_id'        => $plurk->plurk_id,
                                'mission_code'    => 'dice_compute'
                            ]);

                    if ($log) {
                        $master_count = $this->countRndNum($plurk->content);
                        // ComputeJob
                        foreach ($responses['responses'] as $response) {
                            $rndnum_count = $this->countRndNum($response['content']);
                            $user_id      = $response['user_id'];
                            if ($master_count < $rndnum_count) {
                                $users[$user_id] = '@'.$responses['friends'][$user_id]['nick_name'];
                            }
                        }
                        //
                        if (count($users) > 0) {
                            $content = implode(' ', $users);
                        } else {
                            $content = '@'.$plurk->nick_name;
                        }
                        $this->qlurk->responseAdd($plurk->plurk_id, 'Winner: '.$content, 'says');
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }

    public function countRndNum($content)
    {
        $document      = new Document($content);
        $dice_imgs     = $document->find('img[class=emoticon]');

        $rndnum_count = 0;
        foreach ($dice_imgs as $element) {
            $rndnum = $element->getAttribute('rndnum');
            $rndnum_count += $rndnum;
        }

        return $rndnum_count;
    }

    public function getResponsesById($plurk_id)
    {
        $resp = $this->qlurk->call('/APP/Responses/getById', [
            'plurk_id'      => (string)$plurk_id,
            'minimal_user'  => 'true',
            'minimal_data'  => 'true'
        ]);

        return $resp;
    }
}
