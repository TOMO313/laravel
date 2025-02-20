<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Place') }}
        </h2>
    </x-slot>
    <div>
        <ul>
            <li><a href="{{ $place->website_url }}">{{ $place->name }}</a></li>
            <li>{{ $place->address }}</li>
            @foreach($openingHours as $openingHour)
            <li>{{ $openingHour }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>