<?php

namespace App\Jobs;

use App\Models\User;
use App\Libraries\PlurkAPI;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PlurkBotBaseJob implements ShouldQueue
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
        $botUser     = User::find(1);
        $this->qlurk = new PlurkAPI($botUser);

        //Listen private Plurk
        $plurk_ids = [];
        $actives   = $this->getActive();
        foreach ($actives as $active) {
            // get private plurk ids
            if ($active['type'] == 'private_plurk') {
                $plurk_ids[] = $active['plurk_id']; //1403751489
            }
        }

        // search plurk by id
        foreach ($plurk_ids as $plurk_id) {
            $plurk = $this->getPlurk($plurk_id)['plurk'];
            // check content is "registered"
            if ($plurk['content'] == 'registered') {
                // become fans
                $success_text = $this->setFollowing($plurk['user_id'], 'true')['success_text'];
                //
                if ($success_text == 'ok') {
                    //回覆
                    $this->responseAdd($plurk['plurk_id'], $plurk['content'].' Success', 'says');
                }
            }

            if ($plurk['content'] == 'unregistered') {
                // become fans
                $success_text = $this->setFollowing($plurk['user_id'], 'false')['success_text'];
                //
                if ($success_text == 'ok') {
                    //回覆
                    $this->responseAdd($plurk['plurk_id'], $plurk['content'].' Success', 'says');
                }
            }
        }
    }

    public function responseAdd($plurk_id, $content, $qualifier)
    {
        $resp = $this->qlurk->call('/APP/Responses/responseAdd', [
            'plurk_id'      => (string)$plurk_id,
            'content'       => (string)$content,
            'qualifier'     => (string)$qualifier
        ]);

        return $resp;
    }

    public function setFollowing($user_id, $follow = 'true')
    {
        $resp = $this->qlurk->call('/APP/FriendsFans/setFollowing', [
            'user_id'     => (string)$user_id,
            'follow'      => $follow,
        ]);

        return $resp;
    }

    public function getPlurk($plurk_id)
    {
        $resp = $this->qlurk->call('/APP/Timeline/getPlurk', [
            'plurk_id'     => (string)$plurk_id,
            'minimal_user' => true,
            'minimal_data' => true
        ]);

        return $resp;
    }

    public function getActive()
    {
        $resp = $this->qlurk->call('/APP/Alerts/getActive');

        return $resp;
    }
}
