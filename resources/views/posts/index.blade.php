<x-app-layout>
    <x-slot name="header"> {{-- <x-slot></x-slot>を使うことで、name属性で指定した変数名が定義しているコンポーネントに挿入できる --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Index') }}
        </h2>
    </x-slot>

    <style>
        .star {
            font-size: 300%;
            color: #a09a9a;
        }

        .pagination {
            text-align: center;
            display: inline-block;
        }
    </style>

    @if(session('success'))
    <div class="text-center text-xl">
        {{ session('success') }}
    </div>
    @endif

    <div class="text-center font-bold">
        {{ $success_login_message }}
    </div>

    <div class="p-6">
        @foreach($posts as $index => $post) {{-- $posts配列のインデックスを$indexに格納 --}}
        <div class="text-center rounded shadow-lg bg-white p-6">
            <ul>
                <li>{{ ($posts->currentPage()-1)*$posts->perPage()+$loop->iteration }}</li> {{-- ($posts->currentPage()-1)は現在のページ番号から1を引く(現在のページ番号が1の場合は0)。*$posts->perPage()は1ページ当たりの表示件数と掛け算する(3件なので*3)。+$loop->iterationは現在の繰り返し回数を足し算する(最初の$postは1なので+1)。 --}}
                <li>
                    <a href="/posts/{{ $post->id }}">
                        <h1>{{ $post->title }}</h1>
                    </a>
                </li>
                <li>
                    <p>{{ $post->body }}</p>
                </li>
                <div class="rating" data-post-id="{{ $post->id }}">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
            </ul>
        </div>
        @endforeach
    </div>
    <div class="text-center">
        {{ $posts->links() }}
    </div>

    <script src="{{ asset('/js/index.js') }}"></script>
</x-app-layout>