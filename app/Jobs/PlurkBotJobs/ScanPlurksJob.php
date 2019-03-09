<?php

namespace App\Jobs\PlurkBotJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Libraries\PlurkAPI;
use App\Models\User;
use App\Models\Plurk;

class ScanPlurksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $qlurk;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, PlurkAPI $qlurk)
    {
        //
        $this->user  = $user;
        $this->qlurk = $qlurk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $plurks = $this->qlurk->getPlurkByFilter();
        foreach ($plurks as $plurk) {
            //
            $plurk_id = $plurk['plurk_id'];
            // if (Plurk::where('plurk_id', $plurk_id)->count() > 0) {
            //     continue;
            // }

            if ($this->matchKeyword($plurk['content_raw'])) {
                // $this->savePlurk($plurk);
            }
        }
    }

    public function matchKeyword($content_raw)
    {
        $key_words = ['比大小', '註冊'];
        $key_word  = implode('|^#', $key_words);

        // if (preg_match('/(^registered)|(^unregistered)/', $content_raw)) {
        //     return true;
        // }

        if (preg_match('/^[a-z]*|^#([\x{4e00}-\x{9fa5}]+)/u', $content_raw, $matches)) {
            $key_word = $matches[0];

            return $key_word;
        }

        return false;
    }

    public function savePlurk($plurk)
    {
        Plurk::Create([
            'plurk_id'      => $plurk['plurk_id'],
            'user_id'       => $plurk['owner_id'],
            // 'nick_name'     => $plurk['plurk_users'][$unReadPlurk['owner_id']]['nick_name'],
            'qualifier'     => $plurk['qualifier'],
            'content'       => $plurk['content'],
            'content_raw'   => $plurk['content_raw'],
            // 'posted'    => $plurk['posted'],
        ]);
    }
}
