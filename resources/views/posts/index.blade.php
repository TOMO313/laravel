<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Index') }}
        </h2>
    </x-slot>

    <style>
        .star {
            font-size: 300%;
            color: #a09a9a;
        }
    </style>

    <div class="p-6">
        @foreach($posts as $post)
        <div class="text-center rounded shadow-lg bg-white p-6">
            <a href="/posts/{{ $post->id }}"><h1>{{ $post->title }}</h1></a>
            <p>{{ $post->body }}</p>
            <div class="rating" data-post-id="{{ $post->id }}">
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
            </div>
        </div>
        @endforeach
    </div>

    <script src="{{ asset('/js/index.js') }}"></script>
</x-app-layout>