<x-layouts.public title="Mon compte | UberBite(Coin)">
    <section class="mx-auto w-full max-w-7xl px-5 py-10 sm:px-8 sm:py-14">
        <header class="mb-8 border-b border-teal-900/10 pb-6">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Espace membre</p>
            <h1 class="mt-2 text-3xl font-extrabold text-teal-950">Mon compte</h1>
            <p class="mt-2 text-sm text-teal-900/65">Gérez vos informations, votre mot de passe et votre compte.</p>
        </header>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-950/5 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </section>

            <section class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-950/5 sm:p-8">
                @include('profile.partials.update-password-form')
            </section>

            <section class="rounded-2xl border border-red-900/15 bg-white p-6 shadow-lg shadow-teal-950/5 sm:p-8 lg:col-span-2">
                @include('profile.partials.delete-user-form')
            </section>
        </div>
    </section>
</x-layouts.public>
