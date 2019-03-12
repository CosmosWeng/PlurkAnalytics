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
        $plurk_missions = PlurkBotPlurkMission::with(['mission' => function ($query) {
            $query->where('code', 'RegisterUserJob');
        }])
        ->where('status', 1)
        ->get();

        foreach ($plurk_missions as $plurk_mission) {
            //
        }

        dd($plurk_missions);
    }
}
