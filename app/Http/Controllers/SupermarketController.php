<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supermarket;

class SupermarketController extends Controller
{
    public function getPlaceInfo(Supermarket $place)
    {
        //$place->openingHoursで$placeインスタンスに紐づくOpeningHoursクラスのインスタンスをコレクションとして取得する
        //そのコレクション内のopening_hoursカラムを取得するために、コレクションに対してpluck()を使い、特定のカラムだけを取得して配列にして返している
        $openingHours = $place->openingHours->pluck('opening_hours');
        //compact()：キーと値のセットを同時に生成してくれる('openingHours' => $openingHours)
        return view('maps.place-info', compact('place', 'openingHours'));
    }
}
