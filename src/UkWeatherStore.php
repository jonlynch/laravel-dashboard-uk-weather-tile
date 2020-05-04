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

    public function setForecasts(array $data): self
    {
        $this->tile->putData('forecasts', $data);

        return $this;
    }

    public function forecasts(): array
    {
        return $this->tile->getData('forecasts') ?? [];
    }
}
