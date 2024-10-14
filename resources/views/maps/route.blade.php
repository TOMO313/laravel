<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Route') }}
        </h2>
    </x-slot>

    <div class="text-center font-bold">
        <h1>ルート情報</h1>
        @if (isset($leg)) <!-- https://developers.google.com/maps/documentation/routes/reference/rest/v2/TopLevel/computeRoutes?_gl=1*btl3oi*_up*MQ..*_ga*NTI3NzM0MTQ1LjE3Mjg3OTQ2MzU.*_ga_NRWSTWS78N*MTcyODc5NDYzNC4xLjAuMTcyODc5NDcwNi4wLjAuMA..#routeを参照(['route']['leg']ならルートレグを参照) -->
        <p>距離: {{ $leg['localizedValues']['distance']['text'] }}</p>
        <p>所要時間: {{ $leg['localizedValues']['staticDuration']['text'] }}</p>
        <h2>経路ステップ</h2>
        <ul>
            @foreach ($steps as $step)
            <li>
                <p>指示: {{ $step['navigationInstruction']['instructions'] }}</p>
                <p>距離: {{ $step['localizedValues']['distance']['text'] }}</p>
                <p>所要時間: {{ $step['localizedValues']['staticDuration']['text'] }}</p>
            </li>
            @endforeach
        </ul>
        @else
        <p>ルートが見つかりませんでした。</p>
        @endif
        <a class="hover:text-blue-500" href="{{ route('map') }}">戻る</a>
    </div>
</x-app-layout>