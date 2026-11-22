<section>
    <header>
        <h2
            :class="secretMode ? 'text-[#EAE6DF] font-normal italic' : 'text-[#111111]'"
            class="font-serif-luxury text-2xl font-bold"
            x-text="secretMode ? 'Clé de Chiffrement (Mot de passe)' : 'Modifier le mot de passe'"
        >
            Modifier le mot de passe
        </h2>

        <p :class="secretMode ? 'text-neutral-400' : 'text-neutral-500'" class="mt-1 text-xs">
            Protégez l'accès à votre espace privé avec un mot de passe robuste.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label
                for="update_password_current_password"
                :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
            >01 / MOT DE PASSE ACTUEL</label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                :class="secretMode
                    ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                    : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                autocomplete="current-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs text-red-500" />
        </div>

        <div>
            <label
                for="update_password_password"
                :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
            >02 / NOUVEAU MOT DE PASSE</label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                :class="secretMode
                    ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                    : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                autocomplete="new-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs text-red-500" />
        </div>

        <div>
            <label
                for="update_password_password_confirmation"
                :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
            >03 / CONFIRMER LE MOT DE PASSE</label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                :class="secretMode
                    ? 'border-[#C5A47E]/30 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                    : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                class="mt-1.5 block w-full border px-4 py-3 text-sm focus:outline-none"
                autocomplete="new-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs text-red-500" />
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
            >Mettre à jour</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-xs font-semibold text-[#C5A47E]"
                >✓ Mot de passe modifié.</p>
            @endif
        </div>
    </form>
</section>
