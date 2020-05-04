<?php

namespace JonLynch\UkWeatherTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class UkWeatherTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchDataMetOfficeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-uk-weather-tile'),
        ], 'dashboard-uk-weather-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-uk-weather-tile');

        Livewire::component('uk-weather-tile', UkWeatherTileComponent::class);
    }
}
