<?php

namespace App\Console\Commands;

use Database\Seeders\DemoSeeder;
use Illuminate\Console\Command;

class ReloadDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reload:db
                                {--d|demo : Seed demo data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remigrate database and seed relevant data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->environment() === 'production') {
            $this->comment('Nothing need to be done here. Bye.');

            return 0;
        }

        $this->callSilent('migrate:fresh', [
            '--seed' => true,
        ]);

        if($this->option('demo')) {
            $this->callSilent('db:seed', [
                '--class' => DemoSeeder::class,
            ]);
            $this->components->info('Demo data has been seeded.');
        }

        $this->components->info('Successfully reload database.');

        return Command::SUCCESS;
    }
}
