<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot:header>

    <div>
        ここは共同編集ができるところです。
    </div>
    <div>
        <form action="/store" method="POST" onsubmit="">
            @csrf
            <input type="text" id="message" name="message" placeholder="反映されたい文字を入力してください。" />
            <button type="submit">書き込む</button>
        </form>
    </div>
    <div>
        @foreach($messages as $message)
        <h1>{{ $message->user_name }}</h1>
        <p>{{ $message->message }}</p>
        @endforeach
    </div>
</x-app-layout>>