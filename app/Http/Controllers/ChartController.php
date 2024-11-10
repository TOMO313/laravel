<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chart;

class ChartController extends Controller
{
    public function getAmountByYear()
    {
        $amountByYear = Chart::select('year')->selectRaw('SUM(amount) as sumAmount')->groupBy('year')->get(); //select(DB::raw())ではなくselectRaw()。selectRaw('SUM(amount) as sumAmount')->groupBy('year')->get();ではsumAmountしか取得しないため、select('year')でyearも取得。

        return view('charts/chart', ['data' => $amountByYear]);
    }
}
