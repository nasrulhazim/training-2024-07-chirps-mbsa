<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReloadAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload:all
                                {--m|demo : Seed demo data}
                                {--d|dev : Seed development data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload all caches and remigrate database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('reload:cache');
        $this->call('reload:db');

        $this->call('storage:link', [
            '--force' => true,
        ]);

        $this->info('Successfully reload caches and database.');
    }
}
