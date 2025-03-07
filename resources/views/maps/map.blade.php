<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Map') }}
        </h2>
    </x-slot>

    <div id="map" style="height:500px; width:auto"></div>

    <div class="text-center font-bold m-5">
        <form action="{{ route('route') }}" method="POST">
            @csrf
            <label>出発地：</label>
            <input type="text" name="origin" />
            <label>目的地:</label>
            <input type="text" name="destination" />
            <button class="hover:text-blue-500" type="submit">ルート検索</button>
        </form>
    </div>

    <div class="text-center">
        <a class="rounded-full bg-blue-500 hover:bg-yellow-500 p-3" href="/place">NearBy Search</a>
    </div>

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })({
            key: "{{ config('services.google.token') }}", //JavaScript内は{{ config('') }}とする・APIキーは""をつける
            v: "weekly", //APIを週に1回更新
        });
    </script>

    <script src="{{ asset('/js/map.js') }}"></script>
</x-app-layout>