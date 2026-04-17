<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Dziennik</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="antialiased bg-slate-50 text-slate-900 font-sans selection:bg-indigo-500 selection:text-white">

    <nav class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 p-2 rounded-xl text-white shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-slate-800">E-Dziennik</span>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="font-semibold text-slate-600 hover:text-indigo-600 transition">
                                Panel Główny &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-slate-600 hover:text-indigo-600 transition">
                                Zaloguj się
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-sm font-semibold mb-6">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                System aktywny
            </div>
            
            <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl mb-6">
                <span class="block">Nowoczesne zarządzanie</span>
                <span class="block text-indigo-600">Twoją szkołą</span>
            </h1>
            
            <p class="text-lg text-slate-500 mb-10">
                Kompleksowe narzędzie dla uczniów, nauczycieli i administracji. Śledź plan zajęć, sprawdzaj frekwencję i bądź na bieżąco z życiem szkoły.
            </p>
            
            <div class="flex justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 text-lg font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5">
                        Przejdź do swojego profilu
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-4 text-lg font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5">
                        Zaloguj się do systemu
                    </a>
                @endauth
            </div>
        </div>

        <div class="mt-32 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center hover:shadow-md transition">
                <div class="w-14 h-14 mx-auto bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Dla Uczniów</h3>
                <p class="text-slate-500">Zawsze aktualny, przejrzysty plan lekcji i stały podgląd własnej frekwencji.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center hover:shadow-md transition">
                <div class="w-14 h-14 mx-auto bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Dla Nauczycieli</h3>
                <p class="text-slate-500">Wygodne narzędzie do zarządzania listą obecności i błyskawiczny wgląd we własny harmonogram.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center hover:shadow-md transition">
                <div class="w-14 h-14 mx-auto bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Dla Administracji</h3>
                <p class="text-slate-500">Pełna kontrola nad strukturą klas, prowadzącymi oraz centralnym planem lekcji.</p>
            </div>
        </div>
    </main>

    <footer class="mt-12 py-8 border-t border-slate-200">
        <p class="text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} E-Dziennik. Wszystkie prawa zastrzeżone. Projekt zaliczeniowy.
        </p>
    </footer>

</body>
</html>