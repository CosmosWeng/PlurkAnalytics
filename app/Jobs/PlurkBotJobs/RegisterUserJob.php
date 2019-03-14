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

class RegisterUserJob implements ShouldQueue
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
        $user  = User::find(1);
        $qlurk = new PlurkAPI($user);

        $plurk         = $this->plurk_mission->plurk;
        $plurk_mission = $this->plurk_mission;

        //
        $success_text = $qlurk->setFollowing($plurk->user_id, 'true')['success_text'];
        //
        if ($success_text == 'ok') {
            //回覆
            $qlurk->responseAdd($plurk['plurk_id'], $plurk['content'].' Success', 'says');
            // 更改狀態
            $status = 0;
        } else {
            // 更改狀態
            $status = 1;
        }

        $plurk_mission->status = $status;
        $plurk_mission->save();
    }
}
