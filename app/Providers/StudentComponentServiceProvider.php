<?php

namespace App\Providers;

use App\Components\StudentComponent;
use Illuminate\Support\ServiceProvider;

class StudentComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('student', function () {
            return new StudentComponent();
        });
    }

    public function provides()
    {
        return [
            'student'
        ];
    }
}
