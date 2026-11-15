<section>
    <header>
        <h2 class="text-lg font-bold text-teal-950">
            Informations du profil
        </h2>

        <p class="mt-1 text-sm text-teal-900/65">
            Modifiez votre nom et votre adresse e-mail.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-bold text-teal-950">Nom</label>
            <input id="name" name="name" type="text" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <x-input-error class="mt-2 text-sm text-red-600" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-teal-950">Adresse e-mail</label>
            <input id="email" name="email" type="email" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" value="{{ old('email', $user->email) }}" required autocomplete="username">
            <x-input-error class="mt-2 text-sm text-red-600" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-teal-900/75">
                        Votre adresse e-mail n'est pas encore vérifiée.

                        <button form="send-verification" class="text-sm font-semibold text-teal-800 underline decoration-teal-800/30 underline-offset-4 hover:text-teal-950">
                            Renvoyer le lien de vérification
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-semibold text-teal-700">
                            Un nouveau lien de vérification a été envoyé.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-4 border-t border-teal-900/10 pt-5">
            <button type="submit" class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">Enregistrer</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-semibold text-teal-700"
                >Modifications enregistrées.</p>
            @endif
        </div>
    </form>
</section>
