<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @fonts
        <title>{{ config('app.name', 'UberBite(Coin)') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css'])
        @endif

    </head>
    <body class="bg-amber-100 text-white">
        <header class="relative mx-auto mt-8 w-[calc(100%-2rem)] max-w-7xl overflow-hidden rounded-3xl bg-teal-900 px-6 py-12 text-center shadow-xl shadow-teal-900/10 sm:mt-12 sm:px-10 sm:py-16">
            <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-amber-100/20 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-100">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                Le goût du quartier
            </span>
            <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl">
                UberBite<span class="text-amber-400">(Coin)</span>
            </h1>
            <p class="mx-auto mt-4 max-w-md text-base leading-7 text-amber-100/80 sm:text-lg">
                Choisis ce qui te fait envie.
            </p>
            <span class="absolute -right-10 -top-14 h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></span>
            <span class="absolute -bottom-24 -left-8 h-48 w-48 rounded-full border border-amber-400/20" aria-hidden="true"></span>
        </header>

        <main class="mx-auto min-h-[65vh] max-w-7xl px-6 py-10">
        </main>
    </body>
</html>
