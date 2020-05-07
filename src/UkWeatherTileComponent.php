<?php

namespace JonLynch\UkWeatherTile;

use Livewire\Component;

class UkWeatherTileComponent extends Component
{
    /** @var string */
    public $position;

    /** @var string */
    public $configurationName;


    public function mount(string $position, string $configurationName)
    {
        $this->position = $position;

        $this->configurationName = $configurationName;
    }

    public function render()
    {
        return view('dashboard-uk-weather-tile::tile', [
            'forecasts' => UkWeatherStore::make()->forecastsFor($this->configurationName),
            'refreshIntervalInSeconds' => config('dashboard.tiles.ukweather.refresh_interval_in_seconds') ?? 60,
            'location' => $this->configurationName,
        ]);
    }
}
