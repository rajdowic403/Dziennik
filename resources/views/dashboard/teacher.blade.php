<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Nauczyciela - Plan Zajęć') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="calendar-app"></div>
                @viteReactRefresh
                @vite(['resources/js/app.jsx'])
                <div id="teacher-root"></div>
            </div>
        </div>
    </div>

    <script>
        window.userRole = "{{ auth()->user()->roles->first()->name }}";
    </script>
</x-app-layout>