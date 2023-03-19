<?php

namespace App\Providers;

use App\Components\SessionComponent;
use Illuminate\Support\ServiceProvider;

class SessionComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sessionyear', function () {
            return new SessionComponent();
        });
    }

    public function provides()
    {
        return [
            'sessionyear'
        ];
    }
}
