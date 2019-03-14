<?php

namespace App\Jobs\PlurkBotJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DB;
use App\Libraries\PlurkAPI;
use App\Models\User;
use App\Models\Plurk;
use App\Models\PlurkBotMission;
use App\Models\PlurkBotPlurkMission;

class ScanPlurksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 10;

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
        //
        $user  = User::find(1);
        $qlurk = new PlurkAPI($user);

        //
        $plurks = $qlurk->getPlurkByFilter();
        if ($plurks) {
            foreach ($plurks as $plurk) {
                DB::beginTransaction();
                //
                $plurk_id = $plurk['plurk_id'];
                // if (Plurk::where('plurk_id', $plurk_id)->count() > 0) {
                //     continue;
                // }

                if ($key_word = $this->matchKeyword($plurk['content_raw'])) {
                    $mission  = PlurkBotMission::where('keyword', $key_word)->first();
                    if ($mission) {
                        $plurk = $this->savePlurk($plurk);
                        $this->savePlurkMission($plurk, $mission);
                    }
                }
                DB::commit();
            }
        }
    }

    public function matchKeyword($content_raw)
    {
        $key_word = null;
        if (preg_match('/^[a-z]+|^#([\x{4e00}-\x{9fa5}]+)/u', $content_raw, $matches)) {
            $key_word = $matches[0];
        }

        return $key_word;
    }

    public function savePlurkMission($plurk, $mission)
    {
        PlurkBotPlurkMission::create([
            'plurk_id'   => $plurk->plurk_id,
            'nick_name'  => $plurk->nick_name,
            'mission_id' => $mission->id,
        ]);
    }

    public function savePlurk($plurk)
    {
        $plurk = Plurk::create([
            'plurk_id'      => $plurk['plurk_id'],
            'user_id'       => $plurk['owner_id'],
            'nick_name'     => $plurk['nick_name'],
            'qualifier'     => $plurk['qualifier'],
            'content'       => $plurk['content'],
            // 'posted'    => $plurk['posted'],
        ]);

        return $plurk;
    }
}
