<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show') }}
        </h2>
    </x-slot>

    <style>
        .liked{
            color: orange;
            transition: .2s;
        }
    </style>

    <div class="p-6">
        <div class="text-center rounded shadow-lg bg-white p-6">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->body }}</p>
            <p>作成者：{{ $post->user->name }}</p>
            @if($post->isLikedByAuthUser())
                <i class="fa-solid fa-star like-btn liked" id="{{ $post->id }}"></i>
                <p class="count-num">{{ $post->likes->count() }}</p>
            @else
                <i class="fa-solid fa-star like-btn" id="{{ $post->id }}"></i>
                <p class="count-num">{{ $post->likes->count() }}</p>
            @endif
        </div>
    </div>

    <script src="{{ asset('/js/like.js') }}"></script>
</x-app-layout>