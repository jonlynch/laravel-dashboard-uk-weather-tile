<x-dashboard-tile :position="$position">
    <div class="h-full justify-items-center text-center">
        <h1 class="font-medium text-dimmed text-sm uppercase tracking-wide pb-2">
            {{$location}} Weather
        </h1>
        <div wire:poll.{{ $refreshIntervalInSeconds }}s class="self-center grid grid-cols-4 row-gap-1 col-gap-1">
            {{-- tile content --}}
            <div>Time</div>
            <div>Temp &deg;C (Feels)</div>
            <div>Wind mph (Gust)</div>
            <div>Precipitation mm/hr</div>
            @foreach ($forecasts as $forecast)
            <?php 
            $time = \Carbon\Carbon::createFromTimeStamp(strtotime($forecast['time']))
            ?>
             <div>   {{$time ->format('H:i')}}</div>
             <div> {{number_format($forecast['temp'], 0)}} ({{number_format($forecast['feelsLike'], 0)}}) </div>
             <div>{{number_format($forecast['windSpeed'] * 2.24, 0)}} ({{number_format($forecast['windGust'] * 2.24, 0)}})</div>
             <div>{{number_format($forecast['precipRate'],1) }}</div> 
            @endforeach
        </div>
    </div>
</x-dashboard-tile>
