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

class ScanPlurkMissionJob implements ShouldQueue
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
        $pms = PlurkBotPlurkMission::where('status', 1)->get();
        foreach ($pms as $pm) {
            $mission = $pm->mission;
            if ($mission) {
                $class   = 'App\\Jobs\\PlurkBotJobs\\'.$mission->code;
                if (class_exists($class)) {
                    $class::dispatch($this->user, $this->qlurk);
                }
            }
        }
    }
}
