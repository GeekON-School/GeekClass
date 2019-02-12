<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::withoutDoubleEncoding();
        if (config('app.env') != 'local')
        {

            \URL::forceScheme('https');
        }

        /*\DB::listen(function ($query) {
            print(
                $query->sql."<br>"
            );
        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Recaptcha service
        app()->singleton('App\Services\Recaptcha', function () {
            return new \App\Services\Recaptcha();
        });
        app()->singleton('App\Services\EmailVerify', function () {
            return new \App\Services\EmailVerify();
        });
    }
}
