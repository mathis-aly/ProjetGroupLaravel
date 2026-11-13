{{-- resources/views/components/layouts/public.blade.php --}}
@props(['title' => 'PetitesAnnonces'])
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-amber-100 text-teal-900">
    <header class="sticky top-0 z-10 bg-teal-900 text-white shadow-lg shadow-teal-900/10">
        <div class="mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-3 px-6 py-4 sm:flex-row">
            <a class="flex items-center gap-3 text-xl font-extrabold tracking-tight" href="{{ url('/') }}" aria-label="UberBite Coin, accueil">
                <span class="grid h-10 w-10 place-items-center rounded-xl border border-amber-100/20 bg-white/5 text-amber-400" aria-hidden="true">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                        <path d="M4 7h2l2.1 9.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 1.9-1.4L21 10H7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10.5" cy="21" r="1" fill="currentColor"/>
                        <circle cx="18" cy="21" r="1" fill="currentColor"/>
                    </svg>
                </span>
                <span>UberBite<span class="text-amber-400">(Coin)</span></span>
            </a>

            <nav class="flex w-full items-center justify-between gap-3 sm:w-auto sm:justify-end sm:gap-6" aria-label="Navigation principale">
                <a class="text-sm font-semibold text-white/80 transition hover:text-amber-400" href="{{ url('/accueil') }}">Accueil</a>
                <a class="text-sm font-semibold text-white/80 transition hover:text-amber-400" href="{{ url('/annonces') }}">Annonces</a>
                <div class="flex items-center gap-2">
                    @auth
                        <a class="rounded-xl bg-amber-400 px-4 py-2.5 text-sm font-bold text-teal-950 transition hover:bg-amber-300" href="{{ route('dashboard') }}">Mon compte</a>
                    @else
                        <a class="rounded-xl border border-white/25 px-4 py-2.5 text-sm font-bold text-white transition hover:border-amber-400 hover:text-amber-400" href="{{ route('login') }}">Connexion</a>
                        <a class="rounded-xl bg-amber-400 px-4 py-2.5 text-sm font-bold text-teal-950 transition hover:bg-amber-300" href="{{ route('register') }}">Inscription</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="bg-teal-900 px-6 py-5 text-white/75">
        <div class="mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-2 text-sm sm:flex-row">
            <span class="font-bold text-white">UberBite<span class="text-amber-400">(Coin)</span></span>
            <span>© {{ date('Y') }} — Le goût du quartier.</span>
        </div>
    </footer>
</body>
</html>
