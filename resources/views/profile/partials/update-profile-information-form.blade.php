@php
    $user = $user ?? auth()->user();
@endphp
<section>
    <header>
        <h2
            :class="secretMode ? 'text-[#EAE6DF] font-normal italic' : 'text-[#111111]'"
            class="font-serif-luxury text-2xl font-bold"
            x-text="secretMode ? 'Identité de Membre & Pseudonyme' : 'Informations du profil'"
        >
            Informations du profil
        </h2>

        <p :class="secretMode ? 'text-neutral-400' : 'text-neutral-500'" class="mt-1 text-xs">
            Modifiez votre nom d'affichage et votre adresse e-mail confidentielle.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label
                for="name"
                :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                x-text="secretMode ? 'I / PSEUDONYME D\'INITIÉ' : '01 / NOM'"
            >01 / NOM</label>
            <input
                id="name"
                name="name"
                type="text"
                :class="secretMode
                    ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                    : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('name')" />
        </div>

        <div>
            <label
                for="email"
                :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
            >02 / ADRESSE E-MAIL</label>
            <input
                id="email"
                name="email"
                type="email"
                :class="secretMode
                    ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                    : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >
            <x-input-error class="mt-2 text-xs text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-xs text-neutral-500">
                        Votre adresse e-mail n'est pas encore vérifiée.

                        <button form="send-verification" class="font-semibold underline">
                            Renvoyer le lien de vérification
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-xs font-semibold text-emerald-600">
                            Un nouveau lien de vérification a été envoyé.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div
            :class="secretMode ? 'border-[#C5A47E]/20' : 'border-[#DFDDD4]'"
            class="flex flex-wrap items-center gap-4 border-t pt-5"
        >
            <button
                type="submit"
                :class="secretMode
                    ? 'bg-[#C5A47E] text-[#08080A] hover:bg-[#D8BC98]'
                    : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                class="px-6 py-3 font-mono-tech text-xs font-bold uppercase tracking-[0.2em] transition"
            >Enregistrer</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-xs font-semibold text-[#C5A47E]"
                >✓ Modifications enregistrées.</p>
            @endif
        </div>
    </form>
</section>
