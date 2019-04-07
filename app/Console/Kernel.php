<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\PlurkBotJobs\ScanPlurksJob;
use App\Jobs\PlurkBotJobs\ScanPlurkMissionJob;
use App\Jobs\PlurkBotJobs\RegisterUserJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Init
        // if (class_exists('User') && class_exists('PlurkAPI')) {
        // $user  = User::find(1);
        // $qlurk = new PlurkAPI($user);
        // }

        // $job = new ScanPlurkMissionJob();
        // $job->dispatch();

        // ScanPlurkMissionJob::dispatch();
        // RegisterUserJob::dispatch($user, $qlurk);

        // Job Plurk Bot
        // $schedule->job(new ScanPlurksJob)->everyMinute();
        // $schedule->job(new ScanPlurkMissionJob())->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
