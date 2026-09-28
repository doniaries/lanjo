<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Activity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
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
        if ($event->user) {
            // Cek apakah user ini baru saja login dalam 5 detik terakhir
            $recentLogin = Activity::where('causer_id', $event->user->id)
                ->where('causer_type', get_class($event->user))
                ->where('event', 'login')
                ->where('created_at', '>=', now()->subSeconds(5))
                ->exists();

            if ($recentLogin) {
                return;
            }

            activity()
                ->causedBy($event->user)
                ->event('login')
                ->withProperties([
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('Pengguna telah masuk');
        }
    }
}
