<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Google Charts') }}
        </h2>
    </x-slot>

    <div class="m-6" id="chart_div"></div>

    <script>
        {{-- 第1引数のcurrentは最新バージョンを指定し、第2引数でcorechartというパッケージをロード --}}
        google.charts.load('current', {
            'packages': ['corechart']
        }); 
        {{-- setOnLoadCallback()でdrawChart()を呼び出す --}}
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var phpData = @json($data); {{-- [year => 2020, sumAmount => 200]というdataコレクションを[{year:2020, sumAmount:200}]というオブジェクトが中に入ったphpData配列に変換 --}}
            var data = new google.visualization.DataTable(); {{-- new google.visualization.DataTable()でデータを定義 --}}
            data.addColumn('string', 'Year'); {{-- string型のYearカラムを追加。円グラフは最初のカラムをstring型にする。 --}}
            data.addColumn('number', 'Amount');
            {{-- phpData配列をforeach()を使ってitemとして1つずつ取り出し、配列の中身はオブジェクトなので.を使って値を取得している。コントローラーのdd()を使ったところ、sumAmountは文字列だったので、paraseFloat()で数値に変換。`${item.year}年`でitem.yearは数値、年は文字列を同時に扱える --}}
            phpData.forEach(item => {
                data.addRow([`${item.year}年`, parseFloat(item.sumAmount)]);
            });
            var options = {
                'title': '年次売上高の比率',
                'width': 400,
                'height': 300
            };
            var chart = new google.visualization.PieChart(document.getElementById('chart_div')); {{-- new google.visualization.PieChart()で特定の場所に円グラフを設定 --}}
            chart.draw(data, options);
        }
    </script>
</x-app-layout>