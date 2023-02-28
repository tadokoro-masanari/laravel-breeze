<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginToLog
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
    public function handle(Login $event): void
    {
        logger()->info($event->user);
        logger()->info($event->guard);
        logger()->info($event->remember);
        logger()->info(request()->ip());
        logger()->info(request()->userAgent());
    }
}
