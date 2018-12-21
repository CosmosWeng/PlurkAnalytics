<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy Code';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path   = base_path();
        // $cmd    = "cd $path && sudo git checkout . && sudo git pull";
        $cmd    = 'echo Hellow ';
        $output = shell_exec($cmd);

        $this->line('cmd: '.$cmd);
        $this->line('output: '.$output);
    }
}
