<?php

namespace JonLynch\UkWeatherTile\Commands;

use Illuminate\Console\Command;
use JonLynch\UkWeatherTile\UkWeatherStore;
use JonLynch\UkWeatherTile\Services\Forecasts;

class FetchMetOfficeDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-uk-weather-data';

    protected $description = 'Fetch weather data from Met Office';

    public function handle()
    {
        $this->info('Fetching weather data stations...');

        $forecasts = Forecasts::getForecasts(
            config('dashboard.tiles.ukweather.client_id'),
            config('dashboard.tiles.ukweather.client_secret'),
            config('dashboard.tiles.ukweather.lat'),
            config('dashboard.tiles.ukweather.lon')
        );

        UkWeatherStore::make()->setForecasts($forecasts);

        $this->info('All done!');
    }
}
