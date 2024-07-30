<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReloadDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload:db
                                {--m|demo : Seed demo data}
                                {--d|dev : Seed development data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload all caches and database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->environment() === 'production') {
            $this->comment('Nothing need to be done here. Bye.');

            return 0;
        }

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        $this->info('Successfully reload database.');

        return Command::SUCCESS;
    }
}
