<x-layouts.public title="Uberbite(Coin)">

    <div class="bg-amber-100 text-white">
        <div class="relative mx-auto mt-8 w-[calc(100%-2rem)] max-w-7xl overflow-hidden rounded-3xl bg-teal-900 px-6 py-12 text-center shadow-xl shadow-teal-900/10 sm:mt-12 sm:px-10 sm:py-16">

            <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl">
                Annonces
            </h1>

            <span class="absolute -right-10 -top-14 h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></span>
            <span class="absolute -bottom-24 -left-8 h-48 w-48 rounded-full border border-amber-400/20" aria-hidden="true"></span>
        </div>
        <section class="mx-auto min-h-[65vh] max-w-7xl px-6 py-10" aria-labelledby="annonces-title">
            <div class="mb-8">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-teal-700">À découvrir près de chez toi</p>
                <h2 id="annonces-title" class="mt-2 text-3xl font-extrabold tracking-tight text-teal-900 sm:text-4xl">
                    Les annonces du moment
                </h2>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="mb-10 grid gap-3 rounded-2xl border border-teal-900/10 bg-white/85 p-4 shadow-lg shadow-teal-900/5 transition-shadow duration-300 focus-within:border-amber-400 focus-within:shadow-md sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_0.8fr_auto] sm:p-5">
                <div class="min-w-0">
                    <label for="listing-search" class="mb-1.5 block text-xs font-bold uppercase text-teal-800">Recherche</label>
                    <input id="listing-search" type="search" name="q" value="{{ request('q') }}" placeholder="Nom de l’article" class="w-full rounded-xl border-teal-900/15 bg-white text-sm text-teal-950 placeholder:text-teal-900/40 focus:border-teal-700 focus:ring-amber-400">
                </div>

                <div class="min-w-0">
                    <label for="listing-category" class="mb-1.5 block text-xs font-bold uppercase text-teal-800">Catégorie</label>
                    <select id="listing-category" name="category" class="w-full rounded-xl border-teal-900/15 bg-white text-sm text-teal-950 focus:border-teal-700 focus:ring-amber-400">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-0">
                    <label for="listing-max-price" class="mb-1.5 block text-xs font-bold uppercase text-teal-800">Prix maximum</label>
                    <div class="relative">
                        <input id="listing-max-price" type="number" name="max_price" min="0" step="0.01" value="{{ request('max_price') }}" placeholder="Sans limite" class="w-full rounded-xl border-teal-900/15 bg-white pr-9 text-sm text-teal-950 placeholder:text-teal-900/40 focus:border-teal-700 focus:ring-amber-400">
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm font-semibold text-teal-900/50">€</span>
                    </div>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="inline-flex min-h-11 flex-1 items-center justify-center rounded-xl bg-teal-900 px-5 text-sm font-bold text-white transition duration-200 hover:bg-teal-800 active:scale-[0.98] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500 motion-reduce:transition-none">
                        Filtrer
                    </button>
                    @if (request()->hasAny(['q', 'category', 'max_price']))
                        <a href="{{ url()->current() }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-teal-900/15 px-4 text-sm font-semibold text-teal-800 transition-colors hover:border-amber-500 hover:bg-amber-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                            Effacer
                        </a>
                    @endif
                </div>
            </form>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-article
                        :slug="$article['slug']"
                        :title="$article['title']"
                        :description="$article['description']"
                        :condition="$article->condition->Label()"
                        :price="$article['price']"
                    />
                @endforeach
            </div>

            @if ($articles->hasPages())
                <nav class="mt-10 flex flex-col gap-4 border-t border-teal-900/10 pt-5 sm:flex-row sm:items-center sm:justify-between" aria-label="Pagination des annonces">
                    <p class="text-sm text-teal-900/65">
                        Affichage <span class="font-bold text-teal-900">{{ $articles->firstItem() }}–{{ $articles->lastItem() }}</span>
                        sur <span class="font-bold text-teal-900">{{ $articles->total() }}</span> annonces
                    </p>

                    <div class="flex flex-wrap items-center gap-1.5">
                        @if ($articles->onFirstPage())
                            <span aria-disabled="true" class="inline-flex min-h-10 items-center rounded-xl border border-teal-900/10 px-3 text-sm font-semibold text-teal-900/35">Précédent</span>
                        @else
                            <a href="{{ $articles->previousPageUrl() }}" rel="prev" class="inline-flex min-h-10 items-center rounded-xl border border-teal-900/15 px-3 text-sm font-semibold text-teal-800 transition-colors hover:border-amber-500 hover:bg-amber-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">Précédent</a>
                        @endif

                        @foreach ($articles->getUrlRange(max(1, $articles->currentPage() - 1), min($articles->lastPage(), $articles->currentPage() + 1)) as $page => $url)
                            @if ($page === $articles->currentPage())
                                <span aria-current="page" class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl bg-teal-900 px-3 text-sm font-bold text-white shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl border border-teal-900/15 px-3 text-sm font-semibold text-teal-800 transition-colors hover:border-amber-500 hover:bg-amber-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($articles->hasMorePages())
                            <a href="{{ $articles->nextPageUrl() }}" rel="next" class="inline-flex min-h-10 items-center rounded-xl border border-teal-900/15 px-3 text-sm font-semibold text-teal-800 transition-colors hover:border-amber-500 hover:bg-amber-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">Suivant</a>
                        @else
                            <span aria-disabled="true" class="inline-flex min-h-10 items-center rounded-xl border border-teal-900/10 px-3 text-sm font-semibold text-teal-900/35">Suivant</span>
                        @endif
                    </div>
                </nav>
            @endif

        </section>


    </div>
    
</x-layouts.public>
 