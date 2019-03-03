<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Plurk;
use App\Models\PlurkBotMissionLog;
use App\Libraries\PlurkAPI;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PlurkBotLinstenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        // Listen Plurk
        $unReadPlurks = $this->getPlurks();

        foreach ($unReadPlurks['plurks'] as $unReadPlurk) {
            if (preg_match('/^#比大小/', $unReadPlurk['content_raw'])) {
                Plurk::Create([
                    'plurk_id'      => $unReadPlurk['plurk_id'],
                    'user_id'       => $unReadPlurk['owner_id'],
                    'nick_name'     => $unReadPlurks['plurk_users'][$unReadPlurk['owner_id']]['nick_name'],
                    'qualifier'     => $unReadPlurk['qualifier'],
                    'content'       => $unReadPlurk['content'],
                    'content_raw'   => $unReadPlurk['content_raw'],
                    // 'posted'    => $unReadPlurk['posted'],
                ]);

                //
                $log = PlurkBotMissionLog::Create([
                    'plurk_id'        => $unReadPlurk['plurk_id'],
                    'mission_code'    => 'one_dice'
                ]);

                if ($log) {
                    $options   = explode(' ', $unReadPlurk['content_raw']);
                    $diceCount = substr_count($options[1], '(dice)');
                    $content   = '';
                    for ($i = 0; $i < $diceCount ; $i++) {
                        $content .= '(dice)';
                    }

                    $this->qlurk->responseAdd($unReadPlurk['plurk_id'], $content, 'says');
                }
            }
        }
    }

    public function getPlurks()
    {
        $resp = $this->qlurk->call('/APP/Timeline/getPlurks', [
            // 'offset'       => $offset,
            // 'limit'        => $limit,
            // 'filter'       => $filter,
            'minimal_user' => 'true',
            'minimal_data' => 'true'
        ]);

        return $resp;
    }
}
