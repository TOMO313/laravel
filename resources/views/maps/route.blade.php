<!DOCTYPE html>
<html>

<head>
    <title>ルート情報</title>
</head>

<body>

    <h1>ルート情報</h1>

    @if (isset($routeData['routes'][0]['legs'][0]))
    @php
    $leg = $routeData['routes'][0]['legs'][0];
    $steps = $leg['steps'];
    @endphp

    <p>距離: {{ $leg['localizedValues']['distance']['text'] }}</p>
    <p>所要時間: {{ $leg['localizedValues']['duration']['text'] }}</p>

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

</body>

</html>