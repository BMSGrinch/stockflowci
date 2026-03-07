<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'StockFlow CI')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon_io/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon_io/favicon-16x16.png') }}">

    {{-- Tailwind (via Vite ou CDN selon ta config) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen flex">
        {{-- Barre latérale globale --}}
        @include('components.start-card')

        {{-- Contenu principal --}}
        <div class="flex-1 flex flex-col">
            {{-- En-tête optionnel par vue --}}
            @hasSection('page-header')
                <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
                    <div class="max-w-6xl mx-auto px-6 py-4">
                        @yield('page-header')
                    </div>
                </header>
            @endif

            <main class="flex-1">
                <div class="max-w-6xl mx-auto px-6 py-6">
                @if(session('success'))
                    <div class="mx-8 mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

            @if(session('error'))
                <div class="mx-8 mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

                    @yield('content')
      
                </div>
            </main>

            {{-- Pied de page global simple --}}
            <footer class="border-t border-slate-200 bg-white/60">
                <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between text-xs text-slate-500">
                    <span>© {{ date('Y') }} StockFlow CI by Kash</span>
                    <span>Construit avec Laravel & Tailwind CSS </span>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>

