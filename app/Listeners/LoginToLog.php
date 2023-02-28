<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\AuthHistory;

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
        //ログファイルに書き込み
        logger()->info($event->user);
        logger()->info($event->guard);
        logger()->info($event->remember);
        logger()->info(request()->ip());
        logger()->info(request()->userAgent());

        //過去のアクセスログと比較
        $new_acceess = AuthHistory::where('user_agent',request()->userAgent())->first();

        AuthHistory::create(
            [
                'user_id' => $event->user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'login_time' => \Carbon\Carbon::now()
            ]
        );

        if(is_null($new_acceess)){
            logger()->info('端末'.request()->userAgent().'からのアクセスです。');
        }
    }
}
