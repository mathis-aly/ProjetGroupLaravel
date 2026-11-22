@php
    $authorName = $article->user?->name ?? 'Inconnu';
    $conditionLabel = $article->condition->label();
    $hash = abs(crc32((string) $article->slug));
    $indexNumber = sprintf('%02d', ($hash % 98) + 1);
    $affinity = 85 + ($hash % 14);
    $age = 24 + ($hash % 12);
    $sealKey = 'card-' . $article->slug;

    $objectPhotos = [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1509048191080-d2984bad6ae5?auto=format&fit=crop&w=1200&q=85',
    ];

    $secretPortraits = [
        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&fit=crop&w=1200&q=85',
        'https://images.unsplash.com/photo-1463453091185-61582044d556?auto=format&fit=crop&w=1200&q=85',
    ];

    $objectImg = $objectPhotos[$hash % count($objectPhotos)];
    $portraitImg = $secretPortraits[$hash % count($secretPortraits)];

    $secretIntention = match ($conditionLabel) {
        'Neuf' => 'Souper Clandestin & Première Nuit',
        'Très bon état' => 'Complicité Suivie & Discrète',
        'Bon état' => 'Escapade Nocturne',
        'Pour pièces' => 'Passion Sans Filtre',
        default => 'Rencontre Confidentielle',
    };
@endphp

<x-layouts.public :title="$article['title'] . ' | UBERBITE / ARCHIVE'">
    <section
        x-data="{
            invitationSent: false,
            rdvSpot: 'Club de Jazz & Speakeasy',
            rdvNote: ''
        }"
        class="mx-auto flex w-full max-w-7xl flex-col px-6 py-8"
        aria-labelledby="article-title"
    >
        {{-- Barre de retour et actions --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <a
                href="{{ url('/annonces') }}"
                :class="secretMode ? 'border-[#C5A47E]/30 text-[#C5A47E] hover:bg-[#C5A47E] hover:text-[#08080A]' : 'border-[#DFDDD4] bg-white text-[#111111] hover:border-[#111111]'"
                class="font-mono-tech inline-flex items-center gap-2 border px-4 py-2 text-[11px] font-bold uppercase tracking-[0.22em] transition"
            >
                <span>←</span>
                <span x-text="secretMode ? 'Retour aux Dossiers' : 'Retour à l\'Archive'">Retour à l'Archive</span>
            </a>

            @if (auth()->check() && auth()->id() === $article->user_id)
                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('listings.edit', ['listing' => $article->slug]) }}"
                        :class="secretMode ? 'bg-[#C5A47E] text-[#08080A]' : 'bg-[#111111] text-[#F6F5F0]'"
                        class="px-5 py-2 text-[11px] font-bold uppercase tracking-[0.2em] transition"
                    >
                        Modifier
                    </a>
                    <form action="{{ route('listings.destroy', ['listing' => $article->slug]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="border border-red-600 bg-red-600/10 px-5 py-2 text-[11px] font-bold uppercase tracking-[0.2em] text-red-500 transition hover:bg-red-600 hover:text-white">
                            Supprimer
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- ======================================================================= --}}
        {{-- VUE 1 : MODE FAÇADE AWWWARDS SWISS EDITORIAL AVEC PHOTO D'OBJET         --}}
        {{-- ======================================================================= --}}
        <article
            x-show="!secretMode"
            class="grid border border-[#DFDDD4] bg-white lg:grid-cols-12"
        >
            <div class="relative min-h-[380px] border-b border-[#DFDDD4] bg-[#ECEAE2] lg:col-span-6 lg:border-b-0 lg:border-r">
                <img
                    src="{{ $objectImg }}"
                    alt="{{ $article['title'] }}"
                    class="h-full w-full object-cover"
                >
                <div class="absolute left-4 top-4 bg-white/95 px-3 py-1.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest text-[#111111]">
                    LOT N° {{ $indexNumber }} — ARCHIVE CERTIFIÉE
                </div>
            </div>

            <div class="flex flex-col justify-between p-8 sm:p-12 lg:col-span-6">
                <div>
                    <div class="flex items-center justify-between border-b border-[#DFDDD4] pb-4 font-mono-tech text-xs text-neutral-500">
                        <span>RÉF. #{{ $article['id'] }}</span>
                        <span>{{ $conditionLabel }}</span>
                    </div>

                    <h1 id="article-title" class="font-serif-luxury mt-6 text-4xl font-bold leading-tight text-[#111111] sm:text-5xl">
                        {{ $article['title'] }}
                    </h1>

                    <p class="font-mono-tech mt-4 text-3xl font-bold text-[#111111] glitch-target">
                        {{ number_format((float) $article['price'], 2, ',', ' ') }} €
                    </p>

                    <div class="mt-6 grid grid-cols-2 border-y border-[#DFDDD4] py-4 text-xs">
                        <div>
                            <p class="font-mono-tech text-[10px] uppercase text-neutral-400">PROPRIÉTAIRE</p>
                            <p class="mt-1 font-bold text-[#111111]">{{ $authorName }}</p>
                        </div>
                        <div>
                            <p class="font-mono-tech text-[10px] uppercase text-neutral-400">LOCALISATION</p>
                            <p class="mt-1 font-bold text-[#111111]">{{ $article->city ?? 'Toulouse' }}</p>
                        </div>
                    </div>

                    <p class="font-mono-tech mt-6 text-[10px] font-bold uppercase tracking-widest text-neutral-400">NOTE DESCRIPTIVE</p>
                    <p class="mt-2 text-sm leading-7 text-neutral-700 sm:text-base">
                        {{ $article['description'] }}
                    </p>
                </div>

                <div class="mt-8 border-t border-[#DFDDD4] pt-6">
                    <a href="{{ route('dashboard') }}" class="inline-flex w-full items-center justify-center bg-[#111111] px-6 py-4 text-xs font-bold uppercase tracking-[0.2em] text-[#F6F5F0] transition hover:bg-neutral-800">
                        Contacter {{ $authorName }} via la Messagerie ↗
                    </a>
                </div>
            </div>
        </article>

        {{-- ======================================================================= --}}
        {{-- VUE 2 : MAISON VESPER — HAUTE COUTURE NOIR & BRONZE CHAMPAGNE           --}}
        {{-- ======================================================================= --}}
        <article
            x-cloak
            x-show="secretMode"
            class="grid overflow-hidden border border-[#C5A47E]/30 bg-[#0B0B0E] lg:grid-cols-12"
        >
            {{-- Colonne gauche : Portrait Clair-Obscur + Sceau de Bronze (5 cols) --}}
            <div class="relative min-h-[460px] border-b border-[#C5A47E]/20 bg-black lg:col-span-5 lg:border-b-0 lg:border-r">
                <img
                    src="{{ $portraitImg }}"
                    alt="Portrait de {{ $authorName }}"
                    :class="isUnsealed('{{ $sealKey }}')
                        ? 'grayscale-0 blur-0 scale-100 brightness-95'
                        : 'grayscale contrast-125 blur-lg scale-110 brightness-50'"
                    class="h-full w-full object-cover transition-all duration-1000"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#08080A] via-transparent to-transparent"></div>

                {{-- Sceau de Bronze à maintenir 1,2s si non brisé --}}
                <div
                    x-show="!isUnsealed('{{ $sealKey }}')"
                    class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 p-6 text-center select-none"
                >
                    <button
                        type="button"
                        @mousedown.prevent="startHoldSeal('{{ $sealKey }}', $event)"
                        @touchstart.prevent="startHoldSeal('{{ $sealKey }}', $event)"
                        :class="holdingId === '{{ $sealKey }}' ? 'seal-holding' : 'hover:scale-105'"
                        class="relative flex h-24 w-24 items-center justify-center rounded-full border border-[#C5A47E] bg-[#08080A]/90 text-[#C5A47E] shadow-2xl transition"
                    >
                        <svg class="pointer-events-none absolute -inset-2 h-[112px] w-[112px] -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="46" stroke="rgba(197, 164, 126, 0.2)" stroke-width="2" fill="none" />
                            <circle
                                cx="50"
                                cy="50"
                                r="46"
                                stroke="#C5A47E"
                                stroke-width="3"
                                stroke-linecap="round"
                                fill="none"
                                stroke-dasharray="289"
                                :stroke-dashoffset="holdingId === '{{ $sealKey }}' ? 289 - (289 * holdProgress / 100) : 289"
                            />
                        </svg>
                        <div class="flex flex-col items-center">
                            <span class="font-serif-luxury text-3xl italic">V</span>
                            <span class="font-mono-tech mt-0.5 text-[9px] uppercase tracking-widest" x-text="holdingId === '{{ $sealKey }}' ? holdProgress + '%' : 'SCEAU'"></span>
                        </div>
                    </button>
                    <p class="font-mono-tech mt-4 max-w-xs text-[10px] uppercase tracking-[0.25em] text-[#C5A47E]">
                        MAINTENIR 1,2S POUR DESCELLER LE PORTRAIT DE {{ strtoupper($authorName) }}
                    </p>
                </div>

                {{-- Infos superposées en bas du portrait --}}
                <div class="absolute bottom-4 left-4 right-4 border border-[#C5A47E]/30 bg-[#08080A]/90 p-4 backdrop-blur-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="font-serif-luxury text-3xl font-normal italic text-white">{{ $authorName }}, {{ $age }}</h2>
                            <p class="font-mono-tech mt-0.5 text-[10px] uppercase tracking-[0.2em] text-[#C5A47E]">{{ $article->city ?? 'Toulouse' }} • {{ $secretIntention }}</p>
                        </div>
                        <span class="border border-[#C5A47E]/40 bg-[#C5A47E]/10 px-3 py-1 font-mono-tech text-xs font-bold text-[#C5A47E]">
                            {{ $affinity }}%
                        </span>
                    </div>
                </div>
            </div>

            {{-- Colonne droite : Décodage du Prétexte & Proposition de Rendez-vous (7 cols) --}}
            <div class="flex flex-col justify-between p-8 sm:p-12 lg:col-span-7">
                <div>
                    <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-3 font-mono-tech text-[10px] uppercase tracking-[0.28em] text-[#C5A47E]">
                        <span>DOSSIER CONFIDENTIEL N° {{ $indexNumber }}</span>
                        <span>PROTOCOLE VESPER</span>
                    </div>

                    <div class="mt-6 border border-[#C5A47E]/20 bg-[#070709] p-5">
                        <p class="font-mono-tech text-[9px] uppercase tracking-[0.28em] text-neutral-500">
                            PRÉTEXTE DE COUVERTURE : « {{ $article['title'] }} »
                        </p>
                        <p class="font-serif-luxury mt-3 text-lg italic leading-relaxed text-[#EAE6DF]">
                            « {{ $article['description'] }} »
                        </p>
                    </div>

                    <div class="mt-8">
                        <h3 class="font-serif-luxury text-3xl font-normal italic text-white">
                            Initier un Rendez-vous Privé
                        </h3>
                        <p class="mt-1 text-xs text-neutral-400">
                            Sélectionnez le cadre de la rencontre et transmettez votre mot-code à {{ $authorName }}.
                        </p>

                        <div class="mt-5 grid grid-cols-1 gap-2.5 sm:grid-cols-3">
                            <button
                                type="button"
                                @click="rdvSpot = 'Club de Jazz & Speakeasy'"
                                :class="rdvSpot === 'Club de Jazz & Speakeasy' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-neutral-300'"
                                class="border px-3 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest transition"
                            >I. Speakeasy</button>
                            <button
                                type="button"
                                @click="rdvSpot = 'Souper aux Chandelles'"
                                :class="rdvSpot === 'Souper aux Chandelles' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-neutral-300'"
                                class="border px-3 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest transition"
                            >II. Table Secrète</button>
                            <button
                                type="button"
                                @click="rdvSpot = 'Quais de Minuit'"
                                :class="rdvSpot === 'Quais de Minuit' ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]' : 'border-[#C5A47E]/25 bg-[#070709] text-neutral-300'"
                                class="border px-3 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest transition"
                            >III. Heure Tardive</button>
                        </div>

                        <textarea
                            rows="3"
                            x-model="rdvNote"
                            placeholder="Votre message confidentiel en mentionnant « {{ $article['title'] }} »..."
                            class="mt-4 block w-full border border-[#C5A47E]/30 bg-[#070709] px-4 py-3 text-sm text-[#EAE6DF] placeholder:text-neutral-600 focus:border-[#C5A47E] focus:outline-none"
                        ></textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <button
                        type="button"
                        @click="invitationSent = true; breakSeal('{{ $sealKey }}')"
                        class="w-full bg-[#C5A47E] px-6 py-4 font-mono-tech text-[11px] font-bold uppercase tracking-[0.25em] text-[#08080A] transition hover:bg-[#D8BC98]"
                    >
                        Sceller & Transmettre l'Invitation →
                    </button>

                    <div
                        x-cloak
                        x-show="invitationSent"
                        x-transition
                        class="mt-4 border border-[#C5A47E]/40 bg-[#121116] p-4 text-xs text-[#EAE6DF]"
                    >
                        ✓ <strong>Portrait descellé et invitation transmise à {{ $authorName }}</strong> (<span class="text-[#C5A47E]" x-text="rdvSpot"></span>). Retrouvez votre échange dans <a href="{{ route('dashboard') }}" class="font-bold text-[#C5A47E] underline">La Loge</a>.
                    </div>
                </div>
            </div>
        </article>
    </section>
</x-layouts.public>
