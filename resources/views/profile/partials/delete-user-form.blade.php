<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-800">
            Supprimer le compte
        </h2>

        <p class="mt-1 text-sm text-teal-900/65">
            Cette action est définitive et supprimera vos annonces ainsi que les données associées.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Supprimer mon compte</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-red-800">
                Confirmer la suppression du compte
            </h2>

            <p class="mt-1 text-sm text-teal-900/65">
                Saisissez votre mot de passe pour confirmer cette suppression définitive.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Mot de passe</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400 sm:w-3/4"
                    placeholder="Mot de passe"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="border border-teal-900/20 bg-white text-teal-900 hover:bg-teal-900/5">
                    Annuler
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Confirmer la suppression
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
