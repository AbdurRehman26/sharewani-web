<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\ContactUs;
use App\Observers\ContactUsObserver;

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
