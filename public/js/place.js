let map;

async function initMap() {
    //Mapクラス：地図を表示するために用意。
    const { Map } = await google.maps.importLibrary("maps");
    //AdvanceMarkerElementクラス：マーカー表示のために用意
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            //getCurrentPosition()で返されるpositionオブジェクトの中身(https://memopad.bitter.jp/w3c/html5/html5_geolocation.html)
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                //5行目の記述をしない場合、map = new google.maps.Map()と記述する(最新版はimportLibrary()を使用)
                map = new Map(document.getElementById("map"), {
                    center: pos,
                    zoom: 11,
                    mapId: "DEMO_MAP_ID",
                });
                const markerCurrentLocation = new AdvancedMarkerElement({
                    map,
                    //マーカーが表示される位置
                    position: pos,
                });
                nearbySearch(pos);
            },
            () => {
                alert("現在地を取得できませんでした");
            }
        );
    } else {
        // Browser doesn't support Geolocation
        alert("あなたのブラウザは現在地の取得をサポートしていません");
    }
}

async function nearbySearch(pos) {
    //Placeクラス：場所を表示するために用意。SearchNearbyRankPreferenceクラス：場所をランク付けするために用意。
    const { Place, SearchNearbyRankPreference } =
        await google.maps.importLibrary("places");
    const request = {
        //レスポンスに含めるデータ
        fields: ["displayName", "formattedAddress", "location", "websiteURI"],
        //検索範囲
        locationRestriction: {
            //中心
            center: pos,
            //半径(m)
            radius: 1500,
        },
        //表示される場所の種類(スーパーマーケットなど)
        includedPrimaryTypes: ["supermarket"],
        //返される場所の最大数
        maxResultCount: 5,
        //返された場所を人気度順にランク付け
        rankPreference: SearchNearbyRankPreference.POPULARITY,
    };
    //PlaceクラスのsearchNearby()：指定した条件でリクエストを行い、レスポンスを返す。
    //{ places }：レスポンスは{ "places" : [ ~ ] }の形なので、キー名がplacesのものだけ格納(分割代入)
    //https://developers.google.com/maps/documentation/places/web-service/nearby-search?hl=ja&_gl=1*lh4a1x*_up*MQ..*_ga*MjkwOTMxMDE1LjE3Mzc4NzM1NzQ.*_ga_NRWSTWS78N*MTczNzg3MzU3My4xLjEuMTczNzg3ODI2OS4wLjAuMA..#about_response
    const { places } = await Place.searchNearby(request);

    //PinElementクラス：マーカーのカスタマイズに使用
    const { AdvancedMarkerElement, PinElement } =
        await google.maps.importLibrary("marker");
    //配列.length：配列の要素数(3件場所が返ってこれば要素数は3つとなる)
    if (places.length) {
        //LatLngBoundsクラス：地図上で長方形の範囲を作るために用意
        const { LatLngBounds } = await google.maps.importLibrary("core");
        const bounds = new LatLngBounds();
        const listContainer = document.createElement("ul");
        listContainer.style.padding = "10px";
        listContainer.style.listStyle = "none";
        //awaitはforEach()と相性が悪いため、for( of )で代用
        for (const place of places) {
            //searchNearBy()でリクエストできるfieldsはNearby SearchのBasic、Advanced、Preferredによって異なり、併用して使うことができない
            //Place Detailsから、PlaceクラスのfetchFields()を使い、新たにfieldsを追加したリクエストを行う
            //fetchFields()はレスポンスとして返されたPlaceオブジェクトまたはPlaceIDに対して行える(place.fetchFields())
            //fetchFields()のレスポンスはPromise(非同期処理終わったら~するよといった約束)なので、awaitを使ってPromiseの結果を待つことができる
            await place.fetchFields({
                fields: ["regularOpeningHours"],
            });

            try {
                const response = await fetch("/place/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        placeName: place.Eg.displayName,
                        placeAddress: place.Eg.formattedAddress,
                        placeLat: place.Eg.location.lat,
                        placeLng: place.Eg.location.lng,
                        placeWebsite: place.Eg.websiteURI,
                        openingHours:
                            place.regularOpeningHours.weekdayDescriptions,
                    }),
                });

                if (!response.ok) {
                    throw new Error(`レスポンスステータス: ${response.status}`);
                }

                const jsonParseData = await response.json();
                console.log(jsonParseData.id);
                //bladeにリスト作成
                const listItem = document.createElement("li");
                const link = document.createElement("a");
                link.textContent = place.displayName;
                link.href = `/place/${jsonParseData.id}`;
                listItem.appendChild(link);
                listContainer.appendChild(listItem);
            } catch (error) {
                console.log(error);
            }

            const pinBackground = new PinElement({
                background: "#FBBC04",
            });
            const markerView = new AdvancedMarkerElement({
                map,
                position: place.location,
                //マーカーをホバーしたときに表示される
                title: place.displayName,
                content: pinBackground.element,
            });
            //LatLngBoundsクラスのextend()：インスタンス化されたboundsに指定した緯度経度が含まれるような南西の隅と北東の隅を設定し、長方形の範囲を作る
            bounds.extend(place.location);
        }
        //MapクラスのfitBounds()：boundsに格納されている範囲内で地図を拡大したり中心位置を設定
        map.fitBounds(bounds);
        document.getElementById("map").after(listContainer);
    } else {
        console.log("No results");
    }
}

initMap();
