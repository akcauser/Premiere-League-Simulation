<?php

namespace App\Providers;

use App\Layers\Data\GameData;
use App\Layers\Data\IGameData;
use App\Layers\Service\GameService;
use App\Layers\Service\IGameService;
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
        $this->app->singleton(IGameService::class, GameService::class);
        $this->app->singleton(IGameData::class, GameData::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
