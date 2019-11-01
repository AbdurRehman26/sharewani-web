<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Models\GlobalSettingType;
use App\Data\Repositories\GlobalSettingTypeRepository;

class GlobalSettingTypeRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('GlobalSettingTypeRepository', function () {
            return new GlobalSettingTypeRepository(new GlobalSettingType);
        });

    }
}
