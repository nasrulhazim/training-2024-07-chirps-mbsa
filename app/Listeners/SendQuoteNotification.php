<?php

namespace App\Listeners;

use App\Events\SendQuote;
use App\Models\User;
use App\Notifications\SendQuoteNotification as Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendQuoteNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendQuote $event): void
    {
        $users = User::query()->get();
        $quote = $event->quote;
        
        foreach ($users as $user) {
            $user->notify(new Notification($quote));
        }
    }
}
