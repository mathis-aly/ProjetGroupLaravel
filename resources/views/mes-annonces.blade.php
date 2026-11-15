<x-layouts.public title="Mes annonces | Uberbite(Coin)">

    <div class="bg-amber-100 text-white">
        <div class="relative mx-auto mt-8 w-[calc(100%-2rem)] max-w-7xl overflow-hidden rounded-3xl bg-teal-900 px-6 py-12 text-center shadow-xl shadow-teal-900/10 sm:mt-12 sm:px-10 sm:py-16">
            <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-amber-100/20 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-100">
                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                Votre espace
            </span>

            <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl">
                Mes annonces
            </h1>

            <p class="mx-auto mt-4 max-w-xl text-base leading-7 text-amber-100/80 sm:text-lg">
                Retrouvez ici les articles que vous avez publiés et gérez votre vitrine en un clin d’œil.
            </p>

            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('listings.create') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 transition hover:bg-amber-300">
                    Déposer une annonce
                </a>
                <a href="{{ route('annonces') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 px-5 py-3 text-sm font-bold text-white transition hover:border-amber-400 hover:text-amber-400">
                    Voir toutes les annonces
                </a>
            </div>

            <span class="absolute -right-10 -top-14 h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></span>
            <span class="absolute -bottom-24 -left-8 h-48 w-48 rounded-full border border-amber-400/20" aria-hidden="true"></span>
        </div>

        <section class="mx-auto min-h-[65vh] max-w-7xl px-6 py-10" aria-labelledby="mes-annonces-title">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-teal-700">Votre liste</p>
                    <h2 id="mes-annonces-title" class="mt-2 text-3xl font-extrabold tracking-tight text-teal-900 sm:text-4xl">
                        Vos annonces publiées
                    </h2>
                </div>

                @if ($articles->count() > 0)
                    <span class="inline-flex items-center rounded-full border border-teal-900/15 bg-white px-3 py-1.5 text-sm font-bold text-teal-900 shadow-sm">
                        {{ $articles->count() }} annonce{{ $articles->count() > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>

            @if ($articles->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <x-article
                            :slug="$article['slug']"
                            :title="$article['title']"
                            :description="$article['description']"
                            :condition="$article->condition->Label()"
                            :price="$article['price']"
                            :author="$article->user?->name ?? 'Inconnu'"
                            :canEdit="(int) auth()->id() === (int) $article->user_id"
                        />
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-teal-900/20 bg-white/80 p-10 text-center shadow-lg shadow-teal-900/5">
                    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-3xl text-teal-900">
                        🏷️
                    </div>
                    <h3 class="text-2xl font-extrabold tracking-tight text-teal-900">Aucune annonce pour le moment</h3>
                    <p class="mx-auto mt-3 max-w-lg text-base leading-7 text-teal-900/70">
                        Vous n’avez pas encore publié d’article. Créez votre première annonce pour commencer à vendre ou à donner à vos voisins.
                    </p>
                    <a href="{{ route('listings.create') }}" class="mt-6 inline-flex items-center justify-center rounded-xl bg-teal-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-teal-800">
                        Publier une annonce
                    </a>
                </div>
            @endif
        </section>
    </div>

</x-layouts.public>