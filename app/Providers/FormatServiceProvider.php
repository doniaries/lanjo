<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\IndonesiaFormat;

class FormatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('indonesia-format', function () {
            return new IndonesiaFormat();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
