<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed any relevant data despite of application environment.
        User::updateOrCreate([
            'email' => 'superadmin@app.com',
        ],[
            'name' => 'Superadmin',
            'password' => Hash::make('password'),
        ]);
    }
}
