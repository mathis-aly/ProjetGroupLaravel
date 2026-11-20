<x-layouts.public title="Inscription | UberBite(Coin)">
    <section class="mx-auto flex min-h-[calc(100vh-10rem)] w-full max-w-7xl items-center justify-center px-5 py-12 sm:px-8">
        <div class="w-full max-w-lg rounded-2xl border border-teal-900/10 bg-white p-7 shadow-xl shadow-teal-950/10 sm:p-10">
            <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Rejoignez le quartier</p>
            <h1 class="text-3xl font-extrabold text-teal-950">Créer un compte</h1>
            <p class="mt-2 text-sm text-teal-900/65">Inscrivez-vous pour publier et gérer vos annonces.</p>

            <form method="POST" action="{{ route('register') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-bold text-teal-950">Nom</label>
                    <input id="name" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-teal-950">Adresse e-mail</label>
                    <input id="email" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-teal-950">Mot de passe</label>
                    <input id="password" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" type="password" name="password" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-teal-950">Confirmer le mot de passe</label>
                    <input id="password_confirmation" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" type="password" name="password_confirmation" required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 border-t border-teal-900/10 pt-5">
                    <a class="text-sm font-semibold text-teal-800 underline decoration-teal-800/30 underline-offset-4 transition hover:text-teal-950" href="{{ route('login') }}">
                        Déjà inscrit ?
                    </a>
                    <button type="submit" class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-900">
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.public>
