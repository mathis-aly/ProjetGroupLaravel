<x-layouts.public title="Mes Annonces | UBERBITE / ARCHIVE">

    <div class="mx-auto max-w-7xl px-6 py-10">
        {{-- En-tête Swiss Editorial (Façade) vs Speakeasy (Secret) --}}
        <div
            :class="secretMode
                ? 'rounded-3xl border border-rose-500/35 bg-gradient-to-br from-[#23061C] via-[#13030F] to-[#080106] text-rose-50 shadow-2xl shadow-rose-950/60'
                : 'border border-[#DFDDD4] bg-white text-[#111111]'"
            class="relative overflow-hidden px-6 py-12 sm:px-12 sm:py-16 transition-all duration-700"
        >
            <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                <div>
                    <span
                        :class="secretMode ? 'border-rose-400/40 bg-rose-500/15 text-rose-200 rounded-full' : 'border-[#111111] text-[#111111]'"
                        class="font-mono-tech inline-flex items-center gap-2 border px-3 py-1 text-[10px] font-bold uppercase tracking-[0.25em]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full" :class="secretMode ? 'bg-rose-400 animate-pulse' : 'bg-[#111111]'"></span>
                        <span x-text="secretMode ? 'VOS SIGNAUX CODÉS' : 'INVENTAIRE PERSONNEL'"></span>
                    </span>

                    <h1
                        data-cipher-facade="Mes Pièces Publiées"
                        data-cipher-secret="Mes Prétextes de Rendez-vous"
                        :class="secretMode ? 'italic text-rose-50' : 'text-[#111111]'"
                        class="font-serif-luxury mt-4 text-5xl font-bold tracking-tight sm:text-6xl"
                    >
                        Mes Pièces Publiées
                    </h1>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a
                        href="{{ route('listings.create') }}"
                        :class="secretMode
                            ? 'rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 text-white'
                            : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                        class="inline-flex items-center justify-center px-6 py-3.5 text-xs font-bold uppercase tracking-[0.18em] transition"
                        x-text="secretMode ? '+ Lancer un Nouveau Signal' : '+ Déposer une Pièce'"
                    >
                        + Déposer une Pièce
                    </a>
                </div>
            </div>
        </div>

        <section class="min-h-[55vh] py-10" aria-labelledby="mes-annonces-title">
            <div class="mb-8 flex items-center justify-between">
                <p
                    :class="secretMode ? 'text-rose-300' : 'text-neutral-500'"
                    class="font-mono-tech text-xs font-bold uppercase tracking-widest"
                    x-text="secretMode ? 'CARTES RETOURNÉES EN MODE RENCONTRE' : 'GRILLE D\'ARCHIVE PERSONNELLE'"
                ></p>

                @if ($articles->count() > 0)
                    <span
                        :class="secretMode ? 'border-rose-400/30 bg-rose-950/60 text-rose-200 rounded-full' : 'border-[#DFDDD4] bg-white text-[#111111]'"
                        class="font-mono-tech border px-4 py-1.5 text-xs font-bold"
                    >
                        {{ $articles->count() }} PUBLICATION{{ $articles->count() > 1 ? 'S' : '' }}
                    </span>
                @endif
            </div>

            @if ($articles->count() > 0)
                <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <x-article
                            :slug="$article['slug']"
                            :title="$article['title']"
                            :description="$article['description']"
                            :condition="$article->condition->Label()"
                            :price="$article['price']"
                            :author="$article->user?->name ?? 'Inconnu'"
                        />
                    @endforeach
                </div>
            @else
                <div
                    :class="secretMode ? 'rounded-3xl border-rose-400/25 bg-[#180514] text-rose-100' : 'border-[#DFDDD4] bg-white text-[#111111]'"
                    class="border p-12 text-center"
                >
                    <h3
                        class="font-serif-luxury text-3xl font-bold"
                        x-text="secretMode ? 'Aucun signal secret actif' : 'Aucune pièce dans votre archive'"
                    >Aucune pièce dans votre archive</h3>
                    <p
                        :class="secretMode ? 'text-rose-200/70' : 'text-neutral-600'"
                        class="mx-auto mt-3 max-w-lg text-sm leading-7"
                        x-text="secretMode
                            ? 'Publiez une annonce de façade qui servira de mot de passe codé pour attirer vos premiers prétendants.'
                            : 'Soumettez votre première pièce à l’archive UberBite.'"
                    ></p>
                    <a
                        href="{{ route('listings.create') }}"
                        :class="secretMode ? 'rounded-xl bg-rose-500 text-white' : 'bg-[#111111] text-[#F6F5F0]'"
                        class="mt-6 inline-flex items-center justify-center px-6 py-3.5 text-xs font-bold uppercase tracking-[0.2em] transition"
                        x-text="secretMode ? 'Publier mon premier code' : 'Déposer une annonce'"
                    >
                        Déposer une annonce
                    </a>
                </div>
            @endif
        </section>
    </div>

</x-layouts.public>
