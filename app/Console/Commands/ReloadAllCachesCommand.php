<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReloadAllCachesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload:caches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload all available caches in Laravel in one go';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('schedule:clear-cache');
        $this->call('auth:clear-resets');
    }
}
