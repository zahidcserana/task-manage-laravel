<?php

namespace App\Providers;

use App\Components\AdmissionComponent;
use Illuminate\Support\ServiceProvider;

class AdmissionComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('admission', function () {
            return new AdmissionComponent();
        });
    }

    public function provides()
    {
        return [
            'admission'
        ];
    }
}
