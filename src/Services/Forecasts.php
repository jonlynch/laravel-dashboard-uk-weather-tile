<?php

namespace JonLynch\UkWeatherTile\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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
                    'windGust' => $forecast['max10mWindGust'] ?? '',
                    'windDir' => $forecast['windDirectionFrom10m'],
                    'feelsLike' => $forecast['feelsLikeTemperature'],
                    'probOfPrecip' => $forecast['probOfPrecipitation'],
                    'precipRate' => $forecast['precipitationRate'],
                ];
            })
            ->filter(function ($forecast){
                return Carbon::now() < Carbon::createFromTimeStamp(strtotime($forecast['time']))
                                    ->setTimezone('Europe/London');
            })
            ->take(24)
            ->toArray();
    }
}
