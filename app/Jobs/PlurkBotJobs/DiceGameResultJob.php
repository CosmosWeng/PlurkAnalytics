<?php

namespace App\Jobs\PlurkBotJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Libraries\PlurkAPI;
use App\Models\User;
use App\Models\PlurkBotPlurkMission;
use DiDom\Document;

class DiceGameResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $plurk_mission;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PlurkBotPlurkMission $plurk_mission)
    {
        $this->plurk_mission = $plurk_mission;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $user  = User::find(1);
        $qlurk = new PlurkAPI($user);

        $plurk         = $this->plurk_mission->plurk;
        $plurk_mission = $this->plurk_mission;

        list($tagText, $diceText, $count)  = array_pad(explode(' ', strip_tags($plurk->content)), 3, 1);
        //
        $winers    = [];
        $equalers  = [];
        $result    = $qlurk->getResponsesById($plurk->plurk_id);

        if ($count && (int)$result['response_count'] >= (int)$count) {
            $master_count = $this->countRndNum($plurk->content);
            // ComputeJob
            foreach ($result['responses'] as $response) {
                $rndnum_count = $this->countRndNum($response['content']);
                $user_id      = $response['user_id'];
                //
                if ($rndnum_count) {
                    if ($rndnum_count > $master_count) {
                        $winers[$user_id] = '@'.$result['friends'][$user_id]['nick_name'];
                    } elseif ($rndnum_count == $master_count) {
                        $equalers[$user_id] = '@'.$result['friends'][$user_id]['nick_name'];
                    }
                }
            }
            //
            $plurk_mission->status = 1;
            $plurk_mission->save();

            if (count($winers) > 0) {
                $content = 'Winner: '.implode(' ', $winers);
            } elseif (count($equalers) > 0) {
                $content = 'Equal: '.implode(' ', $equalers);
            } else {
                $content = 'Winner: '.'@'.$plurk->nick_name;
            }

            $qlurk->responseAdd($plurk->plurk_id, $content, 'says');

            //
            $plurk_mission->status = 0;
            $plurk_mission->save();
        }
    }

    public function countRndNum($content)
    {
        $rndnum_count = 0;
        if ($content) {
            $document  = new Document($content);
            $dice_imgs = $document->find('img[alt=(dice)]');

            if ($dice_imgs && count($dice_imgs) > 0) {
                foreach ($dice_imgs as $element) {
                    $rndnum = $element->getAttribute('rndnum');
                    $rndnum_count += $rndnum;
                }
            }
        }

        return $rndnum_count;
    }
}
