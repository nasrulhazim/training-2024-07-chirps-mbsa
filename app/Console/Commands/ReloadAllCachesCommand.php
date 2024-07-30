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
        $this->callSilent('config:clear');
        $this->callSilent('view:clear');
        $this->callSilent('cache:clear');
        $this->callSilent('route:clear');
        $this->callSilent('schedule:clear-cache');
        $this->callSilent('auth:clear-resets');

        $this->components->info('All caches has been cleared.');
    }
}
