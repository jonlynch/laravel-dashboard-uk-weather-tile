<?php

namespace JonLynch\UkWeatherTile\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Forecasts
{
    public static function getForecasts(string $apiKey, string $lat, string $lon): array
    {
        $endpoint = "https://data.hub.api.metoffice.gov.uk/sitespecific/v0/point/hourly?dataSource=BD1&latitude={$lat}longitude={$lon}";

        $headers = [
            "apikey" => $apiKey
        ];

        $response = Http::withHeaders($headers)
            ->get($endpoint)
            ->json();

        //dd($endpoint);
        
        return collect($response->features[0]['properties']['timeSeries'])
            ->map(function (array $forecast) {
                return [
                    'time' => $forecast['time'],
                    'temp' => $forecast['screenTemperature'],
                    'windSpeed' => $forecast['windSpeed10m'],
                    'windGust' => $forecast['max10mWindGust'] ?? '',
                    'windBearing' => $forecast['windDirectionFrom10m'],
                    'feelsLike' => $forecast['feelsLikeTemperature'],
                    'probOfPrecip' => $forecast['probOfPrecipitation'],
                    'precipRate' => $forecast['precipitationRate'],
                    'windDir' => self::windRose($forecast['windDirectionFrom10m'])
                ];
            })
            ->filter(function ($forecast){
                return Carbon::now() < Carbon::createFromTimeStamp(strtotime($forecast['time']))
                                    ->setTimezone('Europe/London');
            })
            ->take(24)
            ->toArray();
    }

    public static function windRose($bearing) {
        $winddir[]="N";
        $winddir[]="NNE";
        $winddir[]="NE";
        $winddir[]="ENE";
        $winddir[]="E";
        $winddir[]="ESE";
        $winddir[]="SE";
        $winddir[]="SSE";
        $winddir[]="S";
        $winddir[]="SSW";
        $winddir[]="SW";
        $winddir[]="WSW";
        $winddir[]="W";
        $winddir[]="WNW";
        $winddir[]="NW";
        $winddir[]="NNW";
        $winddir[]="N";
        return $winddir[round($bearing*16/360)];
   }
   
}
