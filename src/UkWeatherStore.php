<?php

namespace JonLynch\UkWeatherTile;

use Spatie\Dashboard\Models\Tile;

class UkWeatherStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("ukWeather");
    }

    public function setForecastsFor(string $location, array $data): self
    {
        $this->tile->putData('forecasts-'.$location, $data);

        return $this;
    }

    public function forecastsFor(string $location): array
    {
        return $this->tile->getData('forecasts-'.$location) ?? [];
    }
}
