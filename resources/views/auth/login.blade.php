<x-layouts.public title="Connexion | UberBite(Coin)">
    <section class="mx-auto flex min-h-[calc(100vh-10rem)] w-full max-w-7xl items-center justify-center px-5 py-12 sm:px-8">
        <div class="w-full max-w-lg rounded-2xl border border-teal-900/10 bg-white p-7 shadow-xl shadow-teal-950/10 sm:p-10">
            <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Espace membre</p>
            <h1 class="text-3xl font-extrabold text-teal-950">Connexion</h1>
            <p class="mt-2 text-sm text-teal-900/65">Retrouvez vos annonces et votre compte.</p>

            <x-auth-session-status class="mt-5 text-sm font-semibold text-teal-800" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-teal-950">Adresse e-mail</label>
                    <input id="email" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-teal-950">Mot de passe</label>
                    <input id="password" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" type="password" name="password" required autocomplete="current-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <label for="remember_me" class="flex items-center gap-2 text-sm text-teal-900/75">
                    <input id="remember_me" type="checkbox" class="rounded border-teal-900/30 text-teal-800 shadow-sm focus:ring-amber-400" name="remember">
                    {{ __('Remember me') }}
                </label>

                <div class="flex flex-wrap items-center justify-between gap-4 border-t border-teal-900/10 pt-5">
                    @if (Route::has('password.request'))
                        <a class="text-sm font-semibold text-teal-800 underline decoration-teal-800/30 underline-offset-4 transition hover:text-teal-950" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                    <button type="submit" class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-900">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.public>
