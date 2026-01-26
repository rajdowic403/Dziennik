<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="calendar-moderator">
                @viteReactRefresh
                @vite(['resources/js/app.jsx'])
                <div id="moderator-root"></div> 
            </div>
        </div>
    </div>
</x-app-layout>