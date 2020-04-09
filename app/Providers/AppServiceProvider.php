<?php

namespace App\Providers;

use App\Observers\SellerObserver;
use App\Seller;
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
        Seller::observe(SellerObserver::class);
    }
}
