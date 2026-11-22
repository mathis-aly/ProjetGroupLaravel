<x-layouts.public title="Mon compte | UberBite Prestige">
    <section class="mx-auto w-full max-w-7xl px-6 py-10">
        <header class="mb-8 border-b border-white/10 pb-6">
            <p
                :class="secretMode ? 'text-rose-400' : 'text-amber-300'"
                class="text-xs font-bold uppercase tracking-[0.25em]"
                x-text="secretMode ? 'Sanctuaire Personnel' : 'Espace Membre'"
            >Espace Membre</p>
            <h1
                :class="secretMode ? 'text-rose-50 italic' : 'text-stone-100'"
                class="font-serif-luxury mt-2 text-4xl font-bold"
                x-text="secretMode ? 'Mon Passeport Vesper' : 'Mon Compte'"
            >Mon Compte</h1>
            <p class="mt-2 text-sm text-stone-400">Gérez vos informations, votre mot de passe et votre confidentialité.</p>
        </header>

        <div class="grid gap-6 lg:grid-cols-2">
            <section
                :class="secretMode ? 'border-rose-400/25 bg-[#170513]' : 'border-amber-400/20 bg-[#12141D]'"
                class="rounded-2xl border p-6 shadow-xl sm:p-8"
            >
                @include('profile.partials.update-profile-information-form')
            </section>

            <section
                :class="secretMode ? 'border-rose-400/25 bg-[#170513]' : 'border-amber-400/20 bg-[#12141D]'"
                class="rounded-2xl border p-6 shadow-xl sm:p-8"
            >
                @include('profile.partials.update-password-form')
            </section>

            <section class="rounded-2xl border border-red-500/25 bg-[#140A10] p-6 shadow-xl sm:p-8 lg:col-span-2">
                @include('profile.partials.delete-user-form')
            </section>
        </div>
    </section>
</x-layouts.public>
