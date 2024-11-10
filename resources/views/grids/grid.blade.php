<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Grid') }}
    </h2>
  </x-slot>

  <div id="wrapper"></div>

  <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
  <script src="{{ asset('/js/grid.js') }}"></script>
</x-app-layout>