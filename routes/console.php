<?php

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('test:mail', function() {
    $user = User::first();
    Mail::to('nasrul@gmail.com')
        ->send(new WelcomeMail($user));
    $this->components->info('mail sent');
});
