<?php

namespace App\Providers;

use App\Components\BatchComponent;
use Illuminate\Support\ServiceProvider;

class BatchComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('batch', function () {
            return new BatchComponent();
        });
    }

    public function provides()
    {
        return [
            'batch'
        ];
    }
}
