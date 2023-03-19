<?php

namespace App\Providers;

use App\Components\GradeComponent;
use Illuminate\Support\ServiceProvider;

class GradeComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('grade', function () {
            return new GradeComponent();
        });
    }

    public function provides()
    {
        return [
            'grade'
        ];
    }
}
