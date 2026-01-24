<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Zarządzanie Planem Zajęć (Moderator)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <p class="mb-4">Wybierz termin na kalendarzu, aby przypisać lekcję i nauczyciela.</p>
                
                <div id="calendar-root"></div>
            </div>
        </div>
    </div>
</x-app-layout>