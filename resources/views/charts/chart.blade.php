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
        <div class="m-6 text-center">
            <a class="rounded-full bg-blue-500 hover:bg-yellow-500 p-3" href="/google">Google Charts</a>
        </div>
    </div>

    <script>
        var dataAmount = @json($data->pluck('sumAmount')); {{-- pluck()を使用することで、キーがsumAmountの値を抽出して、["200", "300"]のように配列形式のJSONに変換される --}}
        var dataYear = @json($data->pluck('year'));
    </script>
    <script src="{{ asset('/js/chart.js') }}"></script> {{-- jsファイルの読み込みは変数定義の後 --}}
</x-app-layout>