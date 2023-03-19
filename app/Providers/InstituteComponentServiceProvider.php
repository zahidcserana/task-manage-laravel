<?php

namespace App\Providers;

use App\Components\InstituteComponent;
use Illuminate\Support\ServiceProvider;

class InstituteComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('institute', function () {
            return new InstituteComponent();
        });
    }

    public function provides()
    {
        return [
            'institute'
        ];
    }
}
