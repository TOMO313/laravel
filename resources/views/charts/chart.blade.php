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

    <script>
        var dataAmount = @json($data->pluck('sumAmount')); {{-- @jsonはblade内で使用 --}}
        var dataYear = @json($data->pluck('year'));
    </script>
    <script src="{{ asset('/js/chart.js') }}"></script> {{-- jsファイルの読み込みは変数定義の後 --}}
</x-app-layout>