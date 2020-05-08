<?php

namespace JonLynch\UkWeatherTile;

use Livewire\Component;

class UkWeatherTileComponent extends Component
{
    /** @var string */
    public $position;

    /** @var string */
    public $locationName;


    public function mount(string $position, string $locationName)
    {
        $this->position = $position;

        $this->locationName = $locationName;
    }

    public function render()
    {
        return view('dashboard-uk-weather-tile::tile', [
            'forecasts' => UkWeatherStore::make()->forecastsFor($this->locationName),
            'refreshIntervalInSeconds' => config('dashboard.tiles.ukweather.refresh_interval_in_seconds') ?? 60,
            'location' => $this->locationName,
        ]);
    }
}
