{{-- resources/views/components/layouts/public.blade.php --}}
@props(['title' => 'PetitesAnnonces'])
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <p>test</p>
        @auth
        <a href="{{ route('dashboard') }}">Mon compte</a>
        @else
        <a href="{{ route('login') }}">Connexion</a>
        @endauth
    </header>
    <main>
        {{ $slot }}
    </main>
    {{-- ← le contenu de la page vient ici --}}
    <footer>© {{ date('Y') }} PetitesAnnonces</footer>
</body>
</html>