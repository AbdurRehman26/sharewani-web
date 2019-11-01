<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\GlobalSetting;
use App\Data\Repositories\GlobalSettingRepository;

class GlobalSettingRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('GlobalSettingRepository', function () {
            return new GlobalSettingRepository(new GlobalSetting);
        });

    }
}
