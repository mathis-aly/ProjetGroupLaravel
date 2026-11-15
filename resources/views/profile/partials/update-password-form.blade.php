<section>
    <header>
        <h2 class="text-lg font-bold text-teal-950">
            Modifier le mot de passe
        </h2>

        <p class="mt-1 text-sm text-teal-900/65">
            Choisissez un mot de passe long et difficile à deviner.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-bold text-teal-950">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-bold text-teal-950">Nouveau mot de passe</label>
            <input id="update_password_password" name="password" type="password" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-bold text-teal-950">Confirmer le nouveau mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex flex-wrap items-center gap-4 border-t border-teal-900/10 pt-5">
            <button type="submit" class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">Enregistrer le mot de passe</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-semibold text-teal-700"
                >Mot de passe modifié.</p>
            @endif
        </div>
    </form>
</section>
