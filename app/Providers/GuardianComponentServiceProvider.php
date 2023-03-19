<?php

namespace App\Providers;

use App\Components\GuardianComponent;
use Illuminate\Support\ServiceProvider;

class GuardianComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('guardian', function () {
            return new GuardianComponent();
        });
    }

    public function provides()
    {
        return [
            'guardian'
        ];
    }
}
