<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MapController extends Controller
{
    public function getRoute()
    {
        $origin = [
            'latitude' => -37.816,
            'longitude' => 144.964,
        ];
        $destination = [
            'latitude' => -37.815,
            'longitude' => 144.966,
        ];

        $apiKey = env('GOOGLE_ACCESS_TOKEN');
        $url = 'https://routes.googleapis.com/directions/v2:computeRoutes';

        $requestData = [
            'origin' => [
                'location' => [
                    'latLng' => [
                        'latitude' => $origin['latitude'],
                        'longitude' => $origin['longitude'],
                    ]
                ]
            ],
            'destination' => [
                'location' => [
                    'latLng' => [
                        'latitude' => $destination['latitude'],
                        'longitude' => $destination['longitude'],
                    ]
                ]
            ],
            'travelMode' => 'DRIVE',
            'routingPreference' => 'TRAFFIC_AWARE', //現在の交通状況を考慮するオプション
        ]; //https://developers.google.com/maps/documentation/routes/compute_route_directions?hl=ja&_gl=1*tofe7s*_up*MQ..*_ga*NjI0NTk0NzUwLjE3Mjg3MTI3MjM.*_ga_NRWSTWS78N*MTcyODcxMjcyMi4xLjAuMTcyODcxMjk0MC4wLjAuMA..#example_http_route_requestのHTTPリクエスト通りに記述

        $client = new Client(); //クライアントの作成

        try {
            $response = $client->post($url, [ //$response = $client->HTTPメソッド(URL)でリクエストの送信
                'headers' => [
                    'X-Goog-Api-Key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'X-Goog-FieldMask' => '*', //レスポンスで全てのフィールドを取得
                ],
                'json' => $requestData, //jsonオプションでJSONに変換とリクエストの本文として送信
            ]); //https://developers.google.com/maps/documentation/routes/compute_route_directions?hl=ja&_gl=1*tofe7s*_up*MQ..*_ga*NjI0NTk0NzUwLjE3Mjg3MTI3MjM.*_ga_NRWSTWS78N*MTcyODcxMjcyMi4xLjAuMTcyODcxMjk0MC4wLjAuMA..#example_http_route_requestのHTTPリクエスト通りに記述

            $data = json_decode($response->getBody(), true); //getBody()でレスポンスの本文を取得

            return view('maps.route', ['routeData' => $data]);
        } catch (\Exception $e) { //ExceptionはLaravelのクラスで例外を管理、$eはExceptionクラスのインスタンス
            return response()->json(['error' => $e->getMessage()]); //getMessage()はLaravelのメソッドでExceptionに管理されているエラーメッセージを取得
        }
    }
}
