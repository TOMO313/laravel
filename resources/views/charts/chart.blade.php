<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chart') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="place-content-center rounded shadow-lg bg-white p-6"> <!-- place-content-centerでコンテンツを中央に配置 -->
            <canvas style="width: 150px; height: 50px;" id="chart"></canvas> <!-- chart.jsを表示する際にcanvasタグが必要 -->
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('/js/chart.js') }}"></script>
</x-app-layout>
