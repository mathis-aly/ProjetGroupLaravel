<x-layouts.public title="Connexion | UBERBITE / ARCHIVE">
    <section class="mx-auto flex min-h-[calc(100vh-10rem)] w-full max-w-7xl items-center justify-center px-6 py-12">
        <div
            :class="secretMode
                ? 'rounded-3xl border border-rose-400/30 bg-[#170513] text-rose-50 shadow-2xl shadow-rose-950/50'
                : 'border border-[#DFDDD4] bg-white text-[#111111]'"
            class="w-full max-w-lg p-8 sm:p-10"
        >
            <p
                :class="secretMode ? 'text-rose-400' : 'text-neutral-500'"
                class="font-mono-tech mb-2 text-xs font-bold uppercase tracking-[0.25em]"
                x-text="secretMode ? 'ACCÈS SANCTUAIRE' : 'AUTHENTIFICATION'"
            >AUTHENTIFICATION</p>
            <h1
                :class="secretMode ? 'text-rose-50 italic' : 'text-[#111111]'"
                class="font-serif-luxury text-4xl font-bold"
                x-text="secretMode ? 'Entrer dans le Cercle' : 'Connexion'"
            >Connexion</h1>

            <x-auth-session-status class="mt-5 text-xs font-semibold text-emerald-500" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label
                        for="email"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    >01 / ADRESSE E-MAIL</label>
                    <input
                        id="email"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0D030A] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
                </div>

                <div>
                    <label
                        for="password"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    >02 / MOT DE PASSE</label>
                    <input
                        id="password"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0D030A] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
                </div>

                <label for="remember_me" class="flex items-center gap-2 text-xs" :class="secretMode ? 'text-rose-200/70' : 'text-neutral-600'">
                    <input id="remember_me" type="checkbox" class="border-neutral-400 text-[#111111]" name="remember">
                    <span>Se souvenir de moi</span>
                </label>

                <div
                    :class="secretMode ? 'border-rose-500/20' : 'border-[#DFDDD4]'"
                    class="flex flex-wrap items-center justify-between gap-4 border-t pt-5"
                >
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold underline underline-offset-4" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                    <button
                        type="submit"
                        :class="secretMode
                            ? 'rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 text-white'
                            : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                        class="px-6 py-3 text-xs font-bold uppercase tracking-[0.18em] transition"
                    >
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.public>
