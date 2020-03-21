<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {
            // View name
            $view_name = str_replace(['pages.', '.'], ['', '_'], $view->getName());
            $view_name = str_replace('-', '_', $view_name);
            view()->share('view_name', $view_name);

            parse_str(request()->getQueryString(), $queryString);
            view()->share('queryString', json_encode($queryString));
        });
    }
}
