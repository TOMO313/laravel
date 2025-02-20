let map, infoWindow; //変数mapとinfoWindowを宣言

async function initMap() {
    const tokyoTower = { lat: 35.65879840315961, lng: 139.74538998103097 };

    const { Map, InfoWindow } = await google.maps.importLibrary("maps"); //mapsライブラリを読み込んで、MapクラスとInfoWindowクラスを定義
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker"); //markerライブラリを読み込んで、AdvancedMarkerElementクラス(公式にはAdvancedMarkerViewクラスの記載もあったが、サービスが終了している)を定義

    map = new Map(document.getElementById("map"), {
        zoom: 10,
        center: tokyoTower,
        mapId: "DEMO_MAP_ID", //独自のマップスタイルを反映させたい場合に使用(https://developers.google.com/maps/documentation/get-map-id?hl=ja)
    }); //地図

    const marker = new AdvancedMarkerElement({
        map: map, //マーカーを表示する地図
        position: tokyoTower, //マーカーを表示する位置
        title: "東京タワー", //マーカーをmouseoverした時に表示される内容
    });

    infoWindow = new InfoWindow(); //情報ウィンドウ

    const locationButton = document.createElement("button"); //buttonタグを追加
    locationButton.classList.add("custom-map-control-button"); //buttonタグにcustom-map-control-buttonクラスを追加
    locationButton.textContent = "現在地の表示";
    locationButton.style.color = "white";
    locationButton.style.fontFamily = "serif";
    locationButton.style.height = "30px";
    locationButton.style.width = "150px";
    locationButton.style.backgroundColor = "blue"; //class属性以外にもstyleは使える・CSSをJavaScriptで記述する際、styleオブジェクトを使ってbackground-colorプロパティ(CSS)をbackgroundColor(JavaScript)とする。
    locationButton.style.borderRadius = "30px";
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton); //Mapクラスのcontrolsプロパティで、ControlPosition定数で指定したマップの上部中央にコントロールを追加し、pushメソッドでlocationButtonを設置

    locationButton.addEventListener("click", () => {
        if (navigator.geolocation) {
            //Geolocation API(デバイスの位置情報をやり取りするシステム)をサポートしているかをnavigator.geolocationオブジェクトの有無で確認
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    //getCurrentPosition()で、現在地を取得する非同期通信を開始し、第1引数に成功した場合に実行されるコールバック関数を記述
                    const pos = {
                        //{}はキーと値(key: value)で構成されるオブジェクトを指す
                        lat: position.coords.latitude, //position.coords.latitudeは定型
                        lng: position.coords.longitude, //position.coords.longitudeは定型
                    };

                    map.setCenter(pos); //地図の中心の位置

                    infoWindow.setPosition(pos); //情報ウィンドウが表示される位置
                    infoWindow.setContent("現在地はここです！"); //情報ウィンドウに表示される内容
                    infoWindow.open(map); //地図に情報ウィンドウを開く
                },
                () => {
                    //getCurrentPosition()の第二引数に失敗した場合に実行されるコールバック関数を記述
                    handleLocationError(true, infoWindow, map.getCenter()); //handleLocationError()の第1引数はGeolocation APIをサポートしているかどうか(true or false)、第2引数はエラーを表示する情報ウィンドウ、第3引数は地図上に情報ウィンドウを表示する位置(今回はgetCenter()で地図の中央)
                }
            );
        } else {
            //Geolocation APIをサポートしていない場合の処理
            handleLocationError(false, infoWindow, map.getCenter());
        }
    });

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        //browserHasGeolocationにtrueかfalseの値を持たせる
        infoWindow.setPosition(pos);
        infoWindow.setContent(
            browserHasGeolocation
                ? "Error: The Geolocation service failed."
                : "Error: Your browser doesn't support geolocation."
        );
        infoWindow.open(map);
    }
}

initMap(); //定義されたinitMap()を呼び出す

//地図表示(https://developers.google.com/maps/documentation/javascript/load-maps-js-api?hl=ja)
//マーカー表示(https://developers.google.com/maps/documentation/javascript/adding-a-google-map?hl=ja)
//クラス詳細(https://developers.google.com/maps/documentation/javascript/reference?hl=ja)
//Geolocation API(https://developer.mozilla.org/ja/docs/Web/API/Geolocation_API/Using_the_Geolocation_API)
