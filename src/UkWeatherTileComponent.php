<?php

namespace JonLynch\UkWeatherTile;

use Livewire\Component;

class UkWeatherTileComponent extends Component
{
    /** @var string */
    public $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        return view('dashboard-uk-weather-tile::tile', [
            'forecasts' => UkWeatherStore::make()->forecasts(),
            'refreshIntervalInSeconds' => config('dashboard.tiles.ukweather.refresh_interval_in_seconds') ?? 60,

        ]);
    }
}
