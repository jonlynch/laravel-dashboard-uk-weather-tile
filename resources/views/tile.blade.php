<x-dashboard-tile :position="$position">
    <div class="grid grid-rows-auto-1 gap-2 h-full justify-items-center text-center">
        <h1 class="font-medium text-dimmed text-sm uppercase tracking-wide">
            Scafell Pike Weather
        </h1>
        <div wire:poll.{{ $refreshIntervalInSeconds }}s class="self-center">
            {{-- tile content --}}
            @foreach ($forecasts as $forecast)
             <div>   {{$forecast['time']}} {{number_format($forecast['temp'], 0)}}&deg;C </div>
            @endforeach
        </div>
    </div>
</x-dashboard-tile>
