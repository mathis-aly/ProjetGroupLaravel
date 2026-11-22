<x-layouts.public title="Inscription | UBERBITE / ARCHIVE">
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
                x-text="secretMode ? 'INITIATION AU CERCLE' : 'ADHÉSION ARCHIVE'"
            >ADHÉSION ARCHIVE</p>
            <h1
                :class="secretMode ? 'text-rose-50 italic' : 'text-[#111111]'"
                class="font-serif-luxury text-4xl font-bold"
                x-text="secretMode ? 'Devenir Initié(e)' : 'Créer un Compte'"
            >Créer un Compte</h1>

            <form method="POST" action="{{ route('register') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label
                        for="name"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    >01 / NOM OU PSEUDONYME</label>
                    <input
                        id="name"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0D030A] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-500" />
                </div>

                <div>
                    <label
                        for="email"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    >02 / ADRESSE E-MAIL</label>
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
                        autocomplete="username"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
                </div>

                <div>
                    <label
                        for="password"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    >03 / MOT DE PASSE</label>
                    <input
                        id="password"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0D030A] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                    >
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
                </div>

                <div>
                    <label
                        for="password_confirmation"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    >04 / CONFIRMER LE MOT DE PASSE</label>
                    <input
                        id="password_confirmation"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0D030A] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    >
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
                </div>

                <div
                    :class="secretMode ? 'border-rose-500/20' : 'border-[#DFDDD4]'"
                    class="flex flex-wrap items-center justify-between gap-4 border-t pt-5"
                >
                    <a class="text-xs font-semibold underline underline-offset-4" href="{{ route('login') }}">
                        Déjà inscrit ?
                    </a>
                    <button
                        type="submit"
                        :class="secretMode
                            ? 'rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 text-white'
                            : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                        class="px-6 py-3 text-xs font-bold uppercase tracking-[0.18em] transition"
                    >
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-layouts.public>
