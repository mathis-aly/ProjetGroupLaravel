<section class="space-y-6">
    <header>
        <h2
            class="font-serif-luxury text-2xl font-bold text-red-600"
            x-text="secretMode ? 'Effacer toute trace & Quitter le Cercle' : 'Supprimer le compte'"
        >
            Supprimer le compte
        </h2>

        <p :class="secretMode ? 'text-rose-200/60' : 'text-neutral-500'" class="mt-1 text-xs">
            Cette action est irréversible et supprimera vos publications ainsi que l'ensemble de vos données.
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        :class="secretMode ? 'rounded-xl border-red-500/40 bg-red-950/60 text-red-200' : 'border-red-600 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white'"
        class="border px-5 py-3 text-xs font-bold uppercase tracking-wider transition"
        x-text="secretMode ? 'Brûler mon passeport Vesper' : 'Supprimer mon compte'"
    >Supprimer mon compte</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="bg-white p-6 text-[#111111]">
            @csrf
            @method('delete')

            <h2 class="font-serif-luxury text-2xl font-bold text-red-600">
                Confirmer la suppression définitive
            </h2>

            <p class="mt-1 text-xs text-neutral-600">
                Saisissez votre mot de passe pour confirmer cette suppression.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Mot de passe</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full border border-[#DFDDD4] bg-[#F6F5F0] px-4 py-3 text-sm text-[#111111] focus:border-red-600 focus:outline-none sm:w-3/4"
                    placeholder="Mot de passe"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs text-red-600" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="border border-[#DFDDD4] px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-neutral-700"
                >
                    Annuler
                </button>

                <button
                    type="submit"
                    class="bg-red-600 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-red-700"
                >
                    Confirmer la suppression
                </button>
            </div>
        </form>
    </x-modal>
</section>
