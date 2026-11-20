@php
    $user = $user ?? auth()->user();
    $listingsCount = $user?->listings()->count() ?? 0;
@endphp

<x-layouts.public title="Mon compte | UberBite(Coin)">
    <div class="bg-amber-100 text-teal-900">
        {{-- En-tête Hero style du site --}}
        <div class="relative mx-auto mt-8 w-[calc(100%-2rem)] max-w-7xl overflow-hidden rounded-3xl bg-teal-900 px-6 py-10 text-white shadow-xl shadow-teal-900/10 sm:mt-12 sm:px-10 sm:py-14">
            <div class="relative z-10 flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
                <div class="flex flex-col sm:flex-row sm:items-center gap-5">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl border-2 border-amber-400/40 bg-amber-400 text-3xl font-extrabold text-teal-950 shadow-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <span class="mb-3 inline-flex items-center gap-2 rounded-full border border-amber-100/20 bg-white/5 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-amber-100">
                            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                            Espace Mon Compte
                        </span>
                        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-5xl">
                            Bonjour, <span class="text-amber-400">{{ $user->name }}</span>
                        </h1>
                        <p class="mt-2 max-w-xl text-sm leading-6 text-amber-100/80 sm:text-base">
                            Consultez vos statistiques de vente, échangez avec vos acheteurs et gérez vos informations personnelles et votre sécurité.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('mesAnnonces', ['user_name' => $user->name]) }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-4 py-2.5 text-sm font-bold text-white transition hover:border-amber-400 hover:text-amber-400">
                        Mes annonces ({{ $listingsCount }})
                    </a>
                    <a href="{{ route('listings.create') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-4 py-2.5 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">
                        + Déposer une annonce
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-red-300/30 bg-red-500/10 px-4 py-2.5 text-sm font-bold text-red-200 transition hover:bg-red-500/20 hover:text-white">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>

            <span class="pointer-events-none absolute -right-10 -top-14 h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></span>
            <span class="pointer-events-none absolute -bottom-24 -left-8 h-48 w-48 rounded-full border border-amber-400/20" aria-hidden="true"></span>
        </div>

        <div class="mx-auto max-w-7xl space-y-12 px-6 py-10">

            {{-- SECTION 1 : STATISTIQUES FICTIVES --}}
            <section aria-labelledby="stats-title">
                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Performances vendeur</p>
                        <h2 id="stats-title" class="mt-1 text-2xl font-extrabold tracking-tight text-teal-950 sm:text-3xl">
                            Vos statistiques du mois
                        </h2>
                    </div>
                    <span class="inline-flex w-fit items-center gap-2 rounded-full border border-teal-900/15 bg-white px-3.5 py-1.5 text-xs font-bold text-teal-900 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Activité en hausse de +24% sur 30 jours
                    </span>
                </div>

                {{-- Cartes KPI --}}
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Vues cumulées</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">👁️</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">1 284</p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-emerald-700">
                            <span class="rounded-md bg-emerald-100 px-1.5 py-0.5 font-bold">+18%</span>
                            <span>vs le mois dernier (1 088)</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Ventes conclues</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">🤝</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">14</p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-teal-800/80">
                            <span class="rounded-md bg-amber-100 px-1.5 py-0.5 font-bold text-teal-950">3 en cours</span>
                            <span>de négociation</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Gains générés</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">💶</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">485,00 €</p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-emerald-700">
                            <span class="rounded-md bg-emerald-100 px-1.5 py-0.5 font-bold">+120,00 €</span>
                            <span>sur les 7 derniers jours</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Note vendeur</span>
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-100 text-teal-900 font-bold">⭐</span>
                        </div>
                        <p class="mt-4 text-3xl font-extrabold text-teal-950">4,9 <span class="text-lg font-bold text-teal-900/50">/ 5</span></p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-semibold text-teal-800/80">
                            <span class="rounded-md bg-amber-400/30 px-1.5 py-0.5 font-bold text-teal-950">12 avis</span>
                            <span>• 98% de satisfaction</span>
                        </p>
                    </div>
                </div>

                {{-- Graphique d'activité fictif & indicateurs secondaires --}}
                <div class="mt-5 grid gap-5 lg:grid-cols-3">
                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 lg:col-span-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <h3 class="text-base font-extrabold text-teal-950">Fréquentation de vos annonces (7 derniers jours)</h3>
                                <p class="text-xs text-teal-900/65">Nombre de visites quotidiennes sur vos articles publiés</p>
                            </div>
                            <span class="rounded-lg bg-teal-900 px-3 py-1 text-xs font-bold text-amber-400">Moyenne : 42 vues / jour</span>
                        </div>

                        <div class="mt-6 grid grid-cols-7 items-end gap-3 pt-4 h-44 border-b border-teal-900/10">
                            @php
                                $days = [
                                    ['label' => 'Lun', 'views' => 28, 'height' => 'h-20'],
                                    ['label' => 'Mar', 'views' => 35, 'height' => 'h-24'],
                                    ['label' => 'Mer', 'views' => 52, 'height' => 'h-32'],
                                    ['label' => 'Jeu', 'views' => 41, 'height' => 'h-28'],
                                    ['label' => 'Ven', 'views' => 64, 'height' => 'h-36'],
                                    ['label' => 'Sam', 'views' => 78, 'height' => 'h-40'],
                                    ['label' => 'Dim', 'views' => 59, 'height' => 'h-32'],
                                ];
                            @endphp
                            @foreach ($days as $day)
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-[11px] font-bold text-teal-900/70">{{ $day['views'] }}</span>
                                    <div class="w-full max-w-[2.5rem] rounded-t-xl {{ $day['label'] === 'Sam' ? 'bg-amber-400' : 'bg-teal-900 hover:bg-teal-800' }} {{ $day['height'] }} transition"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-2 grid grid-cols-7 text-center">
                            @foreach ($days as $day)
                                <span class="text-xs font-bold text-teal-900/70">{{ $day['label'] }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col justify-between rounded-2xl border border-teal-900/10 bg-teal-900 p-6 text-white shadow-lg shadow-teal-900/5">
                        <div>
                            <span class="inline-block rounded-full bg-white/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-400">
                                Bilan d'engagement
                            </span>
                            <h3 class="mt-3 text-xl font-extrabold">Réactivité exemplaire</h3>
                            <p class="mt-1 text-sm text-amber-100/75">
                                Les acheteurs du quartier apprécient votre rapidité de réponse.
                            </p>
                        </div>

                        <div class="my-6 space-y-4">
                            <div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-amber-100">Taux de réponse messagerie</span>
                                    <span class="text-amber-400">96%</span>
                                </div>
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full w-[96%] rounded-full bg-amber-400"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-amber-100">Annonces ajoutées en favoris</span>
                                    <span class="text-amber-400">37 ❤️</span>
                                </div>
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full w-[78%] rounded-full bg-emerald-400"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-amber-100">Temps de réponse moyen</span>
                                    <span class="text-amber-400">~12 min</span>
                                </div>
                                <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full w-[88%] rounded-full bg-amber-400"></div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-white/5 p-3.5 text-xs text-amber-100/90">
                            💡 <strong class="text-white">Astuce :</strong> Répondre en moins de 15 minutes multiplie par 3 vos chances de conclure une vente.
                        </div>
                    </div>
                </div>
            </section>

            {{-- SECTION 3 : MES INFORMATIONS & SÉCURITÉ DU COMPTE --}}
            <section aria-labelledby="compte-infos-title">
                <div class="mb-6">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Paramètres personnels</p>
                    <h2 id="compte-infos-title" class="mt-1 text-2xl font-extrabold tracking-tight text-teal-950 sm:text-3xl">
                        Mes informations & Sécurité
                    </h2>
                </div>

                {{-- Récapitulatif visuel des informations de l'utilisateur --}}
                <div class="mb-6 rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8">
                    <div class="flex flex-col justify-between gap-4 border-b border-teal-900/10 pb-5 sm:flex-row sm:items-center">
                        <div>
                            <h3 class="text-lg font-extrabold text-teal-950">Aperçu de votre profil</h3>
                            <p class="text-sm text-teal-900/65">Informations publiques et état actuel de votre compte UberBite(Coin).</p>
                        </div>
                        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-100 px-3.5 py-1 text-xs font-bold text-emerald-800">
                            ✓ Compte membre actif
                        </span>
                    </div>

                    <dl class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Nom d'utilisateur</dt>
                            <dd class="mt-1 text-base font-extrabold text-teal-950">{{ $user->name }}</dd>
                        </div>

                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Adresse e-mail</dt>
                            <dd class="mt-1 truncate text-base font-extrabold text-teal-950" title="{{ $user->email }}">{{ $user->email }}</dd>
                        </div>

                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Membre depuis</dt>
                            <dd class="mt-1 text-base font-extrabold text-teal-950">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Récemment' }}
                            </dd>
                        </div>

                        <div class="rounded-xl bg-amber-50/70 p-4 border border-teal-900/5">
                            <dt class="text-xs font-bold uppercase tracking-wider text-teal-700">Annonces publiées</dt>
                            <dd class="mt-1 text-base font-extrabold text-teal-950">
                                {{ $listingsCount }} annonce{{ $listingsCount > 1 ? 's' : '' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Formulaires : Informations du profil + Mot de passe + Suppression --}}
                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8">
                        @include('profile.partials.update-profile-information-form', ['user' => $user])
                    </div>

                    <div class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="rounded-2xl border border-red-900/15 bg-white p-6 shadow-lg shadow-teal-900/5 sm:p-8 lg:col-span-2">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-layouts.public>
