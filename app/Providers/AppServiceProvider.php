<?php

namespace App\Providers;

use Filament\Actions\EditAction;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Gate;
use App\Listeners\LogSuccessfulLogin;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // super_admin bypass semua Gate check
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        // Strict mode — cegah N+1 di luar production
        Model::shouldBeStrict(! app()->isProduction());

        // Global action config
        EditAction::configureUsing(function (EditAction $action) {
            $action->iconButton();
        });

        // Log event login
        Event::listen(Login::class, LogSuccessfulLogin::class);

        // Force HTTPS di production
        if (app()->isProduction()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
