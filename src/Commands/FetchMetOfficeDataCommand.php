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

        foreach (config('dashboard.tiles.ukweather.locations') ?? [] as $location => $configuration) {
            $this->info('lat - ' . $configuration['lat']);
            $this->info('lon- ' . $configuration['lon']);
            $forecasts = Forecasts::getForecasts(
                config('dashboard.tiles.ukweather.apikey'),
                $configuration['lat'],
                $configuration['lon']
            );

            UkWeatherStore::make()->setForecastsFor($location, $forecasts);
        }
        $this->info('All done!');
    }
}
