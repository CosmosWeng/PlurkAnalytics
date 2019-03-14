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

class DiceGameJob implements ShouldQueue
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
        $mission       = $this->plurk_mission->mission;
        $plurk_mission = $this->plurk_mission;

        //

        $diceCount = $this->countImageDice($plurk->content);

        $content   = '';
        for ($i = 0; $i < $diceCount ; $i++) {
            $content .= '(dice)';
        }

        $qlurk->responseAdd($plurk->plurk_id, $content, 'says');

        //
        $plurk_mission->mission_id = $mission->parent;
        $plurk_mission->status     = 1;
        $plurk_mission->save();
    }

    public function countImageDice($content)
    {
        $document      = new Document($content);
        $dice_imgs     = $document->find('img[alt=(dice)]');

        return count($dice_imgs);
    }
}
