<?php

namespace JonLynch\UkWeatherTile\Services;

use Illuminate\Support\Facades\Http;

class Forecasts
{
    public static function getForecasts(string $clientId, string $clientSecret, string $lat, string $lon): array
    {
        $endpoint = "https://api-metoffice.apiconnect.ibmcloud.com/metoffice/production/v0/forecasts/point/hourly?excludeParameterMetadata=false&includeLocationName=false&latitude={$lat}&longitude={$lon}";

        $headers = [
            "X-IBM-Client-Id" => $clientId,
            "X-IBM-Client-Secret" => $clientSecret
        ];

        $response = Http::withHeaders($headers)
            ->get($endpoint)
            ->json();

        return collect($response['features'][0]['properties']['timeSeries'])
            ->map(function (array $forecast) {
                return [
                    'time' => $forecast['time'],
                    'temp' => $forecast['screenTemperature'],
                    'windSpeed' => $forecast['windSpeed10m'],
                    'feelsLike' => $forecast['feelsLikeTemperature']
                ];
            })
            ->take(12)
            ->toArray();
    }
}
