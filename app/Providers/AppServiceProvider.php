<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\ContactUs;
use App\Data\Models\Order;
use App\Observers\ContactUsObserver;
use App\Observers\OrderObserver;

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
        ContactUs::observe(ContactUsObserver::class);
        Order::observe(OrderObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
