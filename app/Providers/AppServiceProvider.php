<?php

namespace App\Providers;

use App\Library\Services\DiscountService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\DiscountServiceInterface', function ($app) {
            return new DiscountService();
        });
    }
}
