@props([
    'slug',
    'title',
    'description',
    'condition',
    'price',
    'author',
    'categoryName' => null,
    'secretRdvType' => null,
    'secretPhoto' => null,
    'secretBio' => null,
    'secretAge' => null,
    'canEdit' => false,
])
@php
    $hash = abs(crc32((string) $slug));
    $indexNumber = sprintf('%02d', ($hash % 98) + 1);
    $affinity = 85 + ($hash % 14);
    $age = $secretAge ?: (24 + ($hash % 12));

    $objectPhotos = [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1509048191080-d2984bad6ae5?auto=format&fit=crop&w=900&q=80',
    ];

    $secretPortraits = [
        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1463453091185-61582044d556?auto=format&fit=crop&w=900&q=80',
    ];

    $objectImg = $objectPhotos[$hash % count($objectPhotos)];
    $portraitImg = $secretPhoto ?: $secretPortraits[$hash % count($secretPortraits)];

    // Le Type de RDV remplace la catégorie en mode secret
    $rdvTypeLabel = $secretRdvType ?: match ($condition) {
        'Neuf' => 'Souper Clandestin à Huis Clos',
        'Très bon état' => 'Bar Clandestin & Grands Crus',
        'Bon état' => 'Virée Nocturne & Évasion',
        'Pour pièces' => 'Alchimie Intense & Sans Filtre',
        default => 'Suite Privée & Hôtel Particulier',
    };

    // Le Créneau Nocturne & Degré d'Intimité remplace le Prix (€) en mode secret
    $numPrice = (float) $price;
    $nocturnalSlot = match (true) {
        $numPrice <= 50  => '21h00 • Premier Verre (Degré I)',
        $numPrice <= 150 => '22h30 • Souper Feutré (Degré II)',
        $numPrice <= 400 => '23h45 • Heure de Minuit (Degré III)',
        default          => '01h15 • Jusqu’à l’Aube (Degré IV)',
    };

    $sealKey = 'card-' . $slug;
@endphp

<div class="card-3d-scene h-[31rem] w-full">
    <div :class="secretMode ? 'is-flipped' : ''" class="card-3d-object">

        {{-- ======================================================================= --}}
        {{-- FACE RECTO (0°) : FAÇADE AWWWARDS SWISS EDITORIAL & PHOTO D'OBJET       --}}
        {{-- ======================================================================= --}}
        <div class="card-3d-face">
            <a href="{{ route('annonce', ['listing' => $slug]) }}" class="group flex h-full flex-col justify-between border border-[#DFDDD4] bg-white p-5 transition duration-500 hover:border-[#111111]">
                <div>
                    <div class="mb-3 flex items-center justify-between border-b border-[#ECEAE2] pb-2.5 text-[11px]">
                        <span class="font-mono-tech font-bold text-neutral-500">N° {{ $indexNumber }} {{ $categoryName ? '• ' . strtoupper($categoryName) : '/ ARCHIVE' }}</span>
                        <span class="font-mono-tech uppercase tracking-wider text-neutral-500">{{ $condition }}</span>
                    </div>

                    <div class="relative h-52 w-full overflow-hidden bg-[#F6F5F0]">
                        <img
                            src="{{ $objectImg }}"
                            alt="{{ $title }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                        >
                        <div class="absolute bottom-2.5 right-2.5 bg-[#111111] px-2.5 py-1 font-mono-tech text-xs font-bold text-[#F6F5F0] glitch-target">
                            {{ number_format((float) $price, 2, ',', ' ') }} €
                        </div>
                    </div>

                    <h2
                        title="{{ $title }}"
                        class="font-serif-luxury mt-4 line-clamp-1 text-2xl font-bold tracking-tight text-[#111111] transition group-hover:opacity-70"
                    >
                        {{ $title }}
                    </h2>

                    <p title="{{ $description }}" class="mt-2 line-clamp-2 text-xs leading-relaxed text-neutral-600">
                        {{ $description }}
                    </p>
                </div>

                <div class="flex items-center justify-between border-t border-[#ECEAE2] pt-3.5 text-xs">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#111111] font-mono-tech text-[10px] font-bold text-[#F6F5F0]">
                            {{ strtoupper(substr($author, 0, 1)) }}
                        </span>
                        <span class="truncate font-semibold text-neutral-800">{{ $author }}</span>
                    </div>
                    <span class="font-mono-tech text-[11px] font-bold uppercase tracking-wider text-[#111111] transition group-hover:translate-x-1">
                        Fiche ↗
                    </span>
                </div>
            </a>
        </div>

        {{-- ======================================================================= --}}
        {{-- FACE VERSO (180°) : MAISON VESPER — TYPE DE RDV & CRÉNEAU NOCTURNE      --}}
        {{-- ======================================================================= --}}
        <div class="card-3d-face card-3d-back">
            <div class="relative flex h-full flex-col justify-between overflow-hidden border border-[#C5A47E]/30 bg-[#0B0B0E] p-5 transition duration-500 hover:border-[#C5A47E]">

                {{-- En-tête : Membre, Âge, Type de RDV (remplace la catégorie) & Affinité --}}
                <div class="flex items-center justify-between gap-2 border-b border-[#C5A47E]/15 pb-3">
                    <div class="min-w-0">
                        <h2 class="font-serif-luxury truncate text-2xl font-normal italic text-[#EAE6DF]">
                            {{ $author }}, <span class="text-base not-italic text-neutral-400">{{ $age }}</span>
                        </h2>
                        <p class="font-mono-tech truncate text-[9px] uppercase tracking-[0.2em] text-[#C5A47E]">
                            {{ $rdvTypeLabel }}
                        </p>
                    </div>
                    <span class="shrink-0 border border-[#C5A47E]/40 bg-[#C5A47E]/10 px-2.5 py-1 font-mono-tech text-[10px] font-bold text-[#C5A47E]">
                        {{ $affinity }}%
                    </span>
                </div>

                {{-- PORTRAIT CLAIR-OBSCUR + SCEAU DE BRONZE --}}
                <div class="relative my-3 h-52 w-full overflow-hidden border border-[#C5A47E]/20 bg-black">
                    <img
                        src="{{ $portraitImg }}"
                        alt="Portrait de {{ $author }}"
                        loading="lazy"
                        :class="isUnsealed('{{ $sealKey }}')
                            ? 'grayscale-0 blur-0 scale-100 brightness-95'
                            : 'grayscale contrast-125 blur-[6px] scale-110 brightness-50'"
                        class="h-full w-full object-cover transition-all duration-1000"
                    >

                    {{-- Badge du Créneau Nocturne (remplace le Prix €) --}}
                    <div class="absolute right-2 top-2 border border-[#C5A47E]/40 bg-[#08080A]/90 px-2.5 py-1 font-mono-tech text-[9px] uppercase tracking-wider text-[#C5A47E] backdrop-blur-md">
                        {{ $nocturnalSlot }}
                    </div>

                    {{-- Sceau de Bronze à maintenir 1,2s --}}
                    <div
                        x-show="!isUnsealed('{{ $sealKey }}')"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-125"
                        class="absolute inset-0 flex flex-col items-center justify-center bg-black/55 p-4 text-center select-none"
                    >
                        <button
                            type="button"
                            @mousedown.prevent.stop="startHoldSeal('{{ $sealKey }}', $event)"
                            @touchstart.prevent.stop="startHoldSeal('{{ $sealKey }}', $event)"
                            :class="holdingId === '{{ $sealKey }}' ? 'seal-holding' : 'hover:scale-105'"
                            class="relative flex h-[74px] w-[74px] items-center justify-center rounded-full border border-[#C5A47E] bg-[#08080A]/90 text-[#C5A47E] shadow-2xl transition"
                        >
                            <svg class="pointer-events-none absolute -inset-1.5 h-[86px] w-[86px] -rotate-90" viewBox="0 0 100 100">
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
                                <span class="font-serif-luxury text-2xl italic">V</span>
                                <span class="font-mono-tech text-[8px] uppercase tracking-[0.2em]" x-text="holdingId === '{{ $sealKey }}' ? holdProgress + '%' : 'SCEAU'">SCEAU</span>
                            </div>
                        </button>
                        <p class="font-mono-tech mt-2.5 text-[9px] uppercase tracking-[0.22em] text-[#C5A47E]/80">
                            MAINTENIR 1,2S POUR DESCELLER
                        </p>
                    </div>

                    {{-- Bandeau de statut une fois descellé --}}
                    <div
                        x-cloak
                        x-show="isUnsealed('{{ $sealKey }}')"
                        class="absolute bottom-2 left-2 right-2 flex items-center justify-between border border-[#C5A47E]/30 bg-[#08080A]/85 px-3 py-1.5 font-mono-tech text-[9px] uppercase tracking-widest text-[#C5A47E] backdrop-blur-md"
                    >
                        <span>PORTRAIT DESCELLÉ</span>
                        <span class="text-emerald-400">● PRÉSENT(E)</span>
                    </div>
                </div>

                {{-- Objet-Code & Action --}}
                <div>
                    <div class="border border-white/10 bg-[#070709] px-3.5 py-2.5">
                        <div class="flex items-center justify-between font-mono-tech text-[9px] uppercase tracking-[0.22em] text-neutral-500">
                            <span>MOT-CODE DE COUVERTURE</span>
                            <span>N° {{ $indexNumber }}</span>
                        </div>
                        <p class="font-serif-luxury mt-0.5 truncate text-base italic text-[#EAE6DF]">
                            « {{ $title }} »
                        </p>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <span
                            class="font-mono-tech text-[9px] uppercase tracking-widest"
                            :class="isUnsealed('{{ $sealKey }}') ? 'text-[#C5A47E]' : 'text-neutral-500'"
                            x-text="isUnsealed('{{ $sealKey }}') ? '✓ EMPREINTE ENREGISTRÉE' : 'DOSSIER CONFIDENTIEL'"
                        ></span>

                        <a
                            href="{{ route('annonce', ['listing' => $slug]) }}"
                            class="inline-flex items-center gap-2 bg-[#C5A47E] px-4 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.2em] text-[#08080A] transition hover:bg-[#D8BC98]"
                        >
                            <span>Dossier</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
