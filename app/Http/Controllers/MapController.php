<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MapController extends Controller
{
    public function getRoute(Request $request)
    {
        $client = new Client(); //クライアントの作成

        $originAddress = $request->input('origin');
        $destinationAddress = $request->input('destination');

        $apiKey = env('GOOGLE_ACCESS_TOKEN');

        $originCoordinate = $this->getCoordinateFromAddress($client, $originAddress, $apiKey); //下に定義しているgetCoordinateFromAddress()を発火させると同時に必要な変数を渡している
        $destinationCoordinate = $this->getCoordinateFromAddress($client, $destinationAddress, $apiKey);

        if (!$originCoordinate || !$destinationCoordinate) { //||はまたはの意味
            return response()->json(['error' => '上手く処理されませんでした']); //response()->json()はJavaScriptで取得することができるが、記述していなくてもエラーが出た際は画面上に表示される
        }

        $origin = [
            'latitude' => $originCoordinate['lat'], //https://developers.google.com/maps/documentation/places/web-service/search-find-place?hl=ja&_gl=1*xaavq2*_up*MQ..*_ga*MTAxMzA5MDU1My4xNzI4ODkyMjAx*_ga_NRWSTWS78N*MTcyODg5MjIwMS4xLjAuMTcyODg5MjIwMS4wLjAuMA..#find-place-responsesを参照
            'longitude' => $originCoordinate['lng'],
        ];
        $destination = [
            'latitude' => $destinationCoordinate['lat'],
            'longitude' => $destinationCoordinate['lng'],
        ];

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
            'languageCode' => 'ja',
        ]; //https://developers.google.com/maps/documentation/routes/reference/rest/v2/TopLevel/computeRoutes?hl=ja&_gl=1*18f939n*_up*MQ..*_ga*MTQzMzQ5NTg1Mi4xNzI4NzkzOTIw*_ga_NRWSTWS78N*MTcyODc5MzkyMC4xLjAuMTcyODc5MzkyMC4wLjAuMA..#http-requestのHTTPリクエストを参照

        $url = 'https://routes.googleapis.com/directions/v2:computeRoutes'; //Route APIリクエストURL

        try {
            $response = $client->post($url, [ //$response = $client->HTTPメソッド(URL)でリクエストの送信
                'headers' => [ //Route APIでヘッダーとしてリクエストするものはGuzzuleのheaderオプションを使う
                    'X-Goog-Api-Key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'X-Goog-FieldMask' => '*', //レスポンスで全てのフィールドを取得
                ], //https://cloud.google.com/apis/docs/system-parameters?hl=ja#definitionsを参照
                'json' => $requestData, //Route APIでJSONの本文としてリクエストするものはGuzzuleのjsonオプションを使い、JSONに変換と本文としてリクエストを行う
            ]); //https://developers.google.com/maps/documentation/routes/compute_route_directions?hl=ja&_gl=1*tofe7s*_up*MQ..*_ga*NjI0NTk0NzUwLjE3Mjg3MTI3MjM.*_ga_NRWSTWS78N*MTcyODcxMjcyMi4xLjAuMTcyODcxMjk0MC4wLjAuMA..#example_http_route_requestを参照

            $data = json_decode($response->getBody(), true); //getBody()でレスポンスの本文を取得
            $leg = $data['routes'][0]['legs'][0]; //https://developers.google.com/maps/documentation/routes/reference/rest/v2/TopLevel/computeRoutes?hl=ja&_gl=1*254cob*_up*MQ..*_ga*ODg2Mzk3NjA2LjE3Mjg4OTI1MTk.*_ga_NRWSTWS78N*MTcyODg5MjUxOS4xLjAuMTcyODg5MjUxOS4wLjAuMA..#response-bodyを参照
            $steps = $leg['steps'];

            return view('maps.route', ['leg' => $leg, 'steps' => $steps]);
        } catch (\Exception $e) { //ExceptionはLaravelのクラスで例外を管理、$eはExceptionクラスのインスタンス
            return response()->json(['error' => $e->getMessage()]); //getMessage()はLaravelのメソッドでExceptionに管理されているエラーメッセージを取得
        }
    }

    public function getCoordinateFromAddress(Client $client, $address, $apiKey)
    {
        $url = 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json'; //Places APIリクエストURL、/jsonはJSON形式でリクエストを行うことを表す

        try {
            $response = $client->get($url, [
                'query' => [ //https://developers.google.com/maps/documentation/places/web-service/search-find-place?hl=ja&_gl=1*paofnr*_up*MQ..*_ga*MTUxNzU5NjE1NS4xNzI4ODkzMzc4*_ga_NRWSTWS78N*MTcyODg5MzM3Ny4xLjAuMTcyODg5MzM3Ny4wLjAuMA..#required-parametersを参照
                    'input' => $address,
                    'inputtype' => 'textquery',
                    'fields' => 'geometry',
                    'key' => $apiKey,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $location = $data['candidates'][0]['geometry']['location']; //https://developers.google.com/maps/documentation/places/web-service/search-find-place?hl=ja&_gl=1*paofnr*_up*MQ..*_ga*MTUxNzU5NjE1NS4xNzI4ODkzMzc4*_ga_NRWSTWS78N*MTcyODg5MzM3Ny4xLjAuMTcyODg5MzM3Ny4wLjAuMA..#find-place-responsesを参照

            return $location;
        } catch (\Exception $e) {
            return null; //呼び出し元のgetRoute()に返すので、response()->json()を使って配列で返そうとするとエラーが起こる
        }
    }
}
