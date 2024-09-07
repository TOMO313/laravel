<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Index') }}
        </h2>
    </x-slot>

    <style>
        .star{
            font-size: 300%;
            color: #a09a9a;
        }
    </style>

    <div class="p-6">
        @foreach($posts as $post)
        <div class="text-center rounded shadow-lg bg-white p-6">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->body }}</p>
            <div class="rating" data-post-id="{{ $post->id }}">
                <span class="star" id="1">★</span>
                <span class="star" id="2">★</span>
                <span class="star" id="3">★</span>
                <span class="star" id="4">★</span>
                <span class="star" id="5">★</span>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
