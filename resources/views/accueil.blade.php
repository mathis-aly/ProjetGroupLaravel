@php
    $secretPortraitsPool = [
        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=1000&q=85',
    ];

    $decodedArticles = $articles->values()->map(function ($art, $idx) use ($secretPortraitsPool) {
        $h = abs(crc32((string) $art->slug));
        $cond = $art->condition->label();
        return [
            'id' => 'card-' . $art->slug,
            'num' => sprintf('%02d', $idx + 1),
            'slug' => $art->slug,
            'title' => $art->title,
            'codeObject' => $art->title,
            'description' => $art->description,
            'confession' => '« ' . Str::limit($art->description, 120) . ' »',
            'price' => number_format((float) $art->price, 0, ',', ' '),
            'district' => $art->city ?? 'Toulouse Centre',
            'name' => $art->user?->name ?? 'Membre Initié',
            'age' => 24 + ($h % 11),
            'affinity' => 86 + ($h % 13),
            'photo' => $secretPortraitsPool[$idx % count($secretPortraitsPool)],
            'intention' => match ($cond) {
                'Neuf' => 'Souper Clandestin & Première Nuit',
                'Très bon état' => 'Complicité Suivie & Discrète',
                'Bon état' => 'Escapade Nocturne',
                'Pour pièces' => 'Passion Sans Filtre',
                default => 'Rencontre Confidentielle',
            },
            'url' => route('annonce', ['listing' => $art->slug]),
        ];
    });
@endphp

<x-layouts.public title="UBERBITE / ARCHIVE — Curated Objects">

    {{-- ======================================================================= --}}
    {{-- MODE 1 : FAÇADE AWWWARDS « SWISS EDITORIAL & FINE GRID » (JOUR)         --}}
    {{-- ======================================================================= --}}
    <div x-show="!secretMode">
        <div class="overflow-hidden border-b border-[#DFDDD4] bg-[#ECEAE2] py-2 text-[11px] font-medium uppercase tracking-[0.24em] text-[#111111]">
            <div class="animate-marquee flex items-center gap-10">
                <span>UBERBITE CURATED ARCHIVE — ÉDITION 2026</span>
                <span>•</span>
                <span>MOBILIER D'ARCHITECTE, HORLOGERIE & OBJETS RARES</span>
                <span>•</span>
                <span>TRANSACTIONS VÉRIFIÉES ENTRE PARTICULIERS</span>
                <span>•</span>
                <span>INDEX N° 01—100 DISPONIBLE</span>
                <span>•</span>
                <span>UBERBITE CURATED ARCHIVE — ÉDITION 2026</span>
                <span>•</span>
                <span>MOBILIER D'ARCHITECTE, HORLOGERIE & OBJETS RARES</span>
                <span>•</span>
                <span>TRANSACTIONS VÉRIFIÉES ENTRE PARTICULIERS</span>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6 py-10">
            <div class="border border-[#DFDDD4] bg-white">
                <div class="grid grid-cols-2 border-b border-[#DFDDD4] text-[11px] font-mono-tech uppercase tracking-widest text-neutral-500 sm:grid-cols-4">
                    <div class="border-r border-[#DFDDD4] px-4 py-2.5">INDEX : 2026 / VOL. IV</div>
                    <div class="border-r border-[#DFDDD4] px-4 py-2.5">ÉDITION : TOULOUSE & FRANCE</div>
                    <div class="hidden border-r border-[#DFDDD4] px-4 py-2.5 sm:block">STATUT : ARCHIVE OUVERTE</div>
                    <div class="px-4 py-2.5 text-right font-bold text-[#111111] glitch-target">100 PIÈCES RÉPERTORIÉES</div>
                </div>

                <div class="grid lg:grid-cols-12">
                    <div class="flex flex-col justify-between border-b border-[#DFDDD4] p-8 sm:p-12 lg:col-span-7 lg:border-b-0 lg:border-r">
                        <div>
                            <span class="font-mono-tech inline-block border border-[#111111] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.25em] text-[#111111]">
                                PLATEFORME D'ÉCHANGES ÉDITORIALE
                            </span>

                            <h1 class="font-serif-luxury mt-6 text-5xl font-bold leading-[1.02] tracking-tight text-[#111111] sm:text-7xl">
                                L’art de l’objet singulier.
                            </h1>

                            <p class="mt-6 max-w-xl text-sm leading-7 text-neutral-600 sm:text-base">
                                Une archive vivante dédiée aux pièces de design, à l’horlogerie mécanique, aux ouvrages rares et aux objets du quotidien dotés d’une âme. Sélectionnés et échangés directement entre particuliers passionnés.
                            </p>
                        </div>

                        <div class="mt-10 flex flex-wrap items-center gap-4 border-t border-[#ECEAE2] pt-6">
                            <a href="{{ route('annonces') }}" class="inline-flex items-center gap-3 bg-[#111111] px-7 py-4 text-xs font-bold uppercase tracking-[0.2em] text-[#F6F5F0] transition hover:bg-neutral-800">
                                <span>Parcourir le Catalogue</span>
                                <span>↗</span>
                            </a>
                            @auth
                                <a href="{{ route('listings.create') }}" class="inline-flex items-center gap-2 border border-[#111111] px-6 py-4 text-xs font-bold uppercase tracking-[0.2em] text-[#111111] transition hover:bg-[#F6F5F0]">
                                    <span>+ Soumettre une Pièce</span>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="grid grid-rows-[1fr_auto] lg:col-span-5">
                        <div class="group relative min-h-[340px] overflow-hidden bg-[#ECEAE2]">
                            <img
                                src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?auto=format&fit=crop&w=1200&q=85"
                                alt="Intérieur design & objets de collection"
                                class="h-full w-full object-cover transition duration-1000 group-hover:scale-105"
                            >
                            <div class="absolute left-4 top-4 bg-white/95 px-3 py-1.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest text-[#111111]">
                                FIG. 01 — SÉLECTION CURATORIALE
                            </div>
                        </div>

                        <div class="grid grid-cols-2 border-t border-[#DFDDD4] bg-[#F6F5F0] text-xs">
                            <div class="border-r border-[#DFDDD4] p-4">
                                <p class="font-mono-tech text-[10px] uppercase text-neutral-500">LOT VEDETTE</p>
                                <p class="font-serif-luxury mt-1 text-lg font-bold text-[#111111]">Mobilier & Luminaires XXe</p>
                            </div>
                            <div class="p-4">
                                <p class="font-mono-tech text-[10px] uppercase text-neutral-500">VÉRIFICATION</p>
                                <p class="font-serif-luxury mt-1 text-lg font-bold text-[#111111]">Remise en main propre</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mt-16" aria-labelledby="annonces-title">
                <div class="mb-10 flex flex-col justify-between gap-4 border-b border-[#DFDDD4] pb-6 sm:flex-row sm:items-end">
                    <div>
                        <p class="font-mono-tech text-xs font-bold uppercase tracking-[0.25em] text-neutral-500">
                            INDEX 01—08 • DERNIÈRES ACQUISITIONS
                        </p>
                        <h2 id="annonces-title" class="font-serif-luxury mt-1 text-4xl font-bold tracking-tight text-[#111111] sm:text-5xl">
                            Les Pièces Récentes de l’Archive
                        </h2>
                    </div>

                    <a href="{{ route('annonces') }}" class="font-mono-tech text-xs font-bold uppercase tracking-[0.2em] text-[#111111] transition hover:opacity-70">
                        Consulter tout l’index (100) ↗
                    </a>
                </div>

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
            </section>
        </div>
    </div>

    {{-- ======================================================================= --}}
    {{-- MODE 2 : MAISON VESPER — LA ROUE D'HORLOGER / CADRAN ROTATIF 360°       --}}
    {{-- ======================================================================= --}}
    <div
        x-cloak
        x-show="secretMode"
        x-data="{
            spatialChapter: 'wheel_suitors', // 'wheel_suitors' | 'wheel_archives' | 'radar'
            wheelAngle: 0,
            isDraggingWheel: false,
            dragStartAngle: 0,
            wheelStartAngle: 0,
            selectedBeaconIdx: 0,

            suitors: [
                {
                    id: 'deck-eleonore',
                    num: '01',
                    name: 'Éléonore V.',
                    age: 28,
                    district: 'Saint-Étienne',
                    coords: '43°35\'58&quot;N 01°26\'59&quot;E',
                    x: 62,
                    y: 48,
                    affinity: 98,
                    intention: 'Souper Clandestin & Grands Crus',
                    codeObject: 'Montre mécanique Lip 1968',
                    confession: '« Retrouvez-moi au fond du club de jazz rue des Filatiers à 22h. Demandez si la montre retarde... »',
                    photo: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-gabriel',
                    num: '02',
                    name: 'Gabriel M.',
                    age: 32,
                    district: 'Les Carmes',
                    coords: '43°35\'49&quot;N 01°26\'39&quot;E',
                    x: 48,
                    y: 62,
                    affinity: 95,
                    intention: 'Conversation de Minuit',
                    codeObject: 'Vinyle Miles Davis — Kind of Blue',
                    confession: '« J’aime les rencontres qui commencent à minuit sur les quais de la Garonne autour d’un vieux single malt. »',
                    photo: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-soline',
                    num: '03',
                    name: 'Soline D.',
                    age: 26,
                    district: 'Capitole',
                    coords: '43°36\'16&quot;N 01°26\'38&quot;E',
                    x: 52,
                    y: 34,
                    affinity: 94,
                    intention: 'Complicité Suivie & Mystère',
                    codeObject: 'Miroir vénitien doré XVIIIe',
                    confession: '« Sensible à l’élégance sobre, à l’ironie et aux regards qui savent garder un secret. »',
                    photo: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-julian',
                    num: '04',
                    name: 'Julian R.',
                    age: 31,
                    district: 'Saint-Cyprien',
                    coords: '43°35\'54&quot;N 01°25\'52&quot;E',
                    x: 28,
                    y: 54,
                    affinity: 91,
                    intention: 'Table Secrète aux Chandelles',
                    codeObject: 'Boîtier Argentique Leica M3',
                    confession: '« Chef privé, je dresse ce soir une table confidentielle pour deux personnes seulement. »',
                    photo: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-celeste',
                    num: '05',
                    name: 'Céleste L.',
                    age: 27,
                    district: 'Jardin Royal',
                    coords: '43°35\'37&quot;N 01°27\'04&quot;E',
                    x: 72,
                    y: 72,
                    affinity: 96,
                    intention: 'Évasion Nocturne',
                    codeObject: 'Recueil Édition Originale 1924',
                    confession: '« Deux coupes de champagne brut, une bibliothèque silencieuse et toute la nuit devant nous. »',
                    photo: 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-maxime',
                    num: '06',
                    name: 'Maxime H.',
                    age: 34,
                    district: 'Bourse',
                    coords: '43°36\'04&quot;N 01°26\'28&quot;E',
                    x: 42,
                    y: 44,
                    affinity: 92,
                    intention: 'Piano-Bar & Nuit Blanche',
                    codeObject: 'Briquet Dupont Laque de Chine',
                    confession: '« Collectionneur d’instants rares. Si vous avez du feu, j’ai le reste de la nuit. »',
                    photo: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                }
            ],

            decodedList: {{ Js::from($decodedArticles) }},

            get activeWheelItems() {
                return this.spatialChapter === 'wheel_archives' ? this.decodedList : this.suitors;
            },

            get stepAngle() {
                const count = this.activeWheelItems.length || 1;
                return 360 / count;
            },

            get activeIndex() {
                const count = this.activeWheelItems.length || 1;
                const step = 360 / count;
                // Quel élément se trouve actuellement en haut à 0° (12h) quand la roue est tournée de wheelAngle ?
                let normalized = ((-Math.round(this.wheelAngle / step)) % count + count) % count;
                return normalized;
            },

            get activeItem() {
                return this.activeWheelItems[this.activeIndex] || this.activeWheelItems[0];
            },

            get activeBeacon() {
                return this.suitors[this.selectedBeaconIdx] || this.suitors[0];
            },

            // Rotation via Touchpad (2/3/4 doigts scroll/swipe ou rotation gesture)
            onWheelSpin(e) {
                const delta = Math.abs(e.deltaX) > Math.abs(e.deltaY) ? e.deltaX : e.deltaY;
                this.wheelAngle -= delta * 0.32;
            },

            // Rotation au clic ou glissement circulaire sur le cadran
            startWheelDrag(e) {
                const rect = this.$refs.wheelDial.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;

                this.isDraggingWheel = true;
                this.dragStartAngle = Math.atan2(clientY - cy, clientX - cx) * (180 / Math.PI);
                this.wheelStartAngle = this.wheelAngle;
            },

            moveWheelDrag(e) {
                if (!this.isDraggingWheel) return;
                const rect = this.$refs.wheelDial.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;

                const currentAngle = Math.atan2(clientY - cy, clientX - cx) * (180 / Math.PI);
                let diff = currentAngle - this.dragStartAngle;
                if (diff > 180) diff -= 360;
                if (diff < -180) diff += 360;

                this.wheelAngle = this.wheelStartAngle + diff;
            },

            stopWheelDrag() {
                if (!this.isDraggingWheel) return;
                this.isDraggingWheel = false;
                this.snapToNearest();
            },

            snapToIndex(idx) {
                const count = this.activeWheelItems.length || 1;
                const step = 360 / count;
                const target = -idx * step;
                // Choisir le chemin angulaire le plus court
                let diff = ((target - this.wheelAngle + 540) % 360) - 180;
                this.wheelAngle = this.wheelAngle + diff;
            },

            snapToNearest() {
                this.snapToIndex(this.activeIndex);
            },

            stepWheel(direction) {
                const count = this.activeWheelItems.length || 1;
                const step = 360 / count;
                this.wheelAngle -= direction * step;
                this.snapToNearest();
            },

            // Calcul trigonométrique (X, Y) de chaque médaillon sur la roue
            getNodeStyle(idx) {
                const count = this.activeWheelItems.length || 1;
                const step = 360 / count;
                // -90° place l'index 0 en haut à 12h (ou 0° à 3h)
                const totalDeg = (idx * step) + this.wheelAngle - 90;
                const rad = totalDeg * (Math.PI / 180);
                const radius = 185; // Rayon en px sur le cadran
                const x = Math.cos(rad) * radius;
                const y = Math.sin(rad) * radius;
                const isSelected = idx === this.activeIndex;
                const scale = isSelected ? 1.22 : 0.88;
                const zIndex = isSelected ? 30 : 10;
                return `transform: translate(calc(-50% + ${x.toFixed(1)}px), calc(-50% + ${y.toFixed(1)}px)) scale(${scale}); z-index: ${zIndex};`;
            }
        }"
        @mousemove.window="moveWheelDrag($event)"
        @mouseup.window="stopWheelDrag()"
        @touchmove.window="moveWheelDrag($event)"
        @touchend.window="stopWheelDrag()"
        class="relative flex h-[calc(100vh-4.1rem)] w-full flex-col justify-between overflow-hidden bg-[#08080A] select-none"
    >
        {{-- ================================================================= --}}
        {{-- BARRE SUPÉRIEURE DE COORDONNÉES & ANGLE DU CADRAN                 --}}
        {{-- ================================================================= --}}
        <div class="flex items-center justify-between border-b border-[#C5A47E]/15 px-6 py-2.5 text-[10px] font-mono-tech uppercase tracking-[0.28em] text-[#C5A47E]/80">
            <div class="flex items-center gap-4">
                <span>CADRAN HORLOGER VESPER</span>
                <span class="text-white/20">|</span>
                <span>ANGLE : <strong class="text-[#EAE6DF]" x-text="(((Math.round(wheelAngle) % 360) + 360) % 360) + '°'">0°</strong></span>
            </div>

            <div class="flex items-center gap-6">
                <span>SCEAUX DESCELLÉS : <strong class="text-[#EAE6DF]" x-text="unsealedIds.length">0</strong></span>
                <span class="hidden sm:inline text-white/20">|</span>
                <span class="hidden sm:inline text-neutral-400">FAITES TOURNER LA ROUE AU TOUCHPAD OU À LA SOURIS</span>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- CHAPITRES I & II : LA ROUE D'HORLOGER INTERACTIVE + DOSSIER       --}}
        {{-- ================================================================= --}}
        <div
            x-show="spatialChapter === 'wheel_suitors' || spatialChapter === 'wheel_archives'"
            @wheel.prevent="onWheelSpin($event)"
            class="grid flex-1 overflow-hidden lg:grid-cols-12"
        >
            {{-- ============================================================= --}}
            {{-- COLONNE GAUCHE (7 COLS) : LA ROUE MÉCANIQUE ROTATIVE 360°     --}}
            {{-- ============================================================= --}}
            <div class="relative flex flex-col items-center justify-center overflow-hidden border-b border-[#C5A47E]/15 bg-[#060608] p-4 lg:col-span-7 lg:border-b-0 lg:border-r">

                {{-- Indicateur du Viseur à 12h (Haut du cadran) --}}
                <div class="pointer-events-none absolute top-4 z-30 flex flex-col items-center">
                    <span class="font-mono-tech text-[9px] uppercase tracking-[0.35em] text-[#C5A47E]">VISEUR ACTIF</span>
                    <div class="mt-1 h-4 w-px bg-[#C5A47E]"></div>
                    <div class="h-2 w-2 rotate-45 border-b border-r border-[#C5A47E]"></div>
                </div>

                {{-- LE CADRAN D'HORLOGER (460x460) --}}
                <div
                    x-ref="wheelDial"
                    @mousedown="startWheelDrag($event)"
                    @touchstart="startWheelDrag($event)"
                    class="relative flex h-[430px] w-[430px] cursor-grab items-center justify-center active:cursor-grabbing sm:h-[470px] sm:w-[470px]"
                >
                    {{-- Couronne extérieure graduée qui tourne avec l'angle --}}
                    <div
                        :style="`transform: rotate(${wheelAngle}deg); transition: ${isDraggingWheel ? 'none' : 'transform 0.35s cubic-bezier(0.22, 1, 0.36, 1)'};`"
                        class="pointer-events-none absolute inset-6 rounded-full border border-[#C5A47E]/25"
                    >
                        {{-- Repères horaires du cadran --}}
                        <span class="absolute -top-1.5 left-1/2 h-3 w-px -translate-x-1/2 bg-[#C5A47E]"></span>
                        <span class="absolute -bottom-1.5 left-1/2 h-3 w-px -translate-x-1/2 bg-[#C5A47E]/50"></span>
                        <span class="absolute left-0 top-1/2 h-px w-3 -translate-y-1/2 bg-[#C5A47E]/50"></span>
                        <span class="absolute right-0 top-1/2 h-px w-3 -translate-y-1/2 bg-[#C5A47E]/50"></span>
                    </div>

                    {{-- Anneaux concentriques fixes --}}
                    <div class="pointer-events-none absolute inset-16 rounded-full border border-dashed border-[#C5A47E]/20"></div>
                    <div class="pointer-events-none absolute inset-32 rounded-full border border-[#C5A47E]/15"></div>

                    {{-- MOYEU CENTRAL DE LA ROUE : LE SCEAU DE BRONZE DU MEMBRE ACTIF --}}
                    <template x-if="activeItem">
                        <div class="relative z-20 flex flex-col items-center justify-center text-center">
                            <button
                                type="button"
                                @mousedown.prevent.stop="startHoldSeal(activeItem.id, $event)"
                                @touchstart.prevent.stop="startHoldSeal(activeItem.id, $event)"
                                :class="holdingId === activeItem.id ? 'seal-holding' : 'hover:scale-105'"
                                class="relative flex h-28 w-28 flex-col items-center justify-center rounded-full border border-[#C5A47E] bg-[#0B0B0F] text-[#C5A47E] shadow-2xl shadow-black transition"
                            >
                                <svg class="pointer-events-none absolute -inset-2 h-[128px] w-[128px] -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="46" stroke="rgba(197, 164, 126, 0.18)" stroke-width="2" fill="none" />
                                    <circle
                                        cx="50"
                                        cy="50"
                                        r="46"
                                        stroke="#C5A47E"
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        fill="none"
                                        stroke-dasharray="289"
                                        :stroke-dashoffset="holdingId === activeItem.id ? 289 - (289 * holdProgress / 100) : (isUnsealed(activeItem.id) ? 0 : 289)"
                                    />
                                </svg>
                                <span class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-neutral-400" x-text="'N° ' + activeItem.num"></span>
                                <span class="font-serif-luxury text-3xl italic text-[#EAE6DF]" x-text="activeItem.name.split(' ')[0]"></span>
                                <span
                                    class="font-mono-tech mt-0.5 text-[8px] uppercase tracking-[0.22em] text-[#C5A47E]"
                                    x-text="holdingId === activeItem.id
                                        ? holdProgress + '%'
                                        : (isUnsealed(activeItem.id) ? '✓ DESCELLÉ' : 'MAINTENIR SCEAU')"
                                ></span>
                            </button>
                        </div>
                    </template>

                    {{-- LES MÉDAILLONS PORTRAITS EN ORBITE SUR LA ROUE --}}
                    <template x-for="(item, idx) in activeWheelItems" :key="item.id">
                        <div
                            @click.stop="snapToIndex(idx)"
                            :style="getNodeStyle(idx) + (isDraggingWheel ? ' transition: none;' : ' transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1);')"
                            class="group absolute left-1/2 top-1/2 cursor-pointer"
                        >
                            <div
                                :class="idx === activeIndex
                                    ? 'border-2 border-[#C5A47E] shadow-2xl shadow-[#C5A47E]/25'
                                    : 'border border-[#C5A47E]/35 opacity-65 hover:opacity-100'"
                                class="relative h-24 w-24 overflow-hidden rounded-full bg-[#0D0D11] transition-all duration-300"
                            >
                                <img
                                    :src="item.photo"
                                    :alt="item.name"
                                    :class="isUnsealed(item.id)
                                        ? 'grayscale-0 blur-0'
                                        : 'grayscale contrast-125 blur-[2px] brightness-75'"
                                    class="h-full w-full object-cover transition-all duration-700"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-1.5 inset-x-0 text-center">
                                    <span class="font-mono-tech text-[9px] font-bold uppercase tracking-wider text-[#EAE6DF]" x-text="item.num"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Commandes manuelles de rotation en bas du cadran --}}
                <div class="mt-2 flex items-center gap-4">
                    <button
                        type="button"
                        @click="stepWheel(-1)"
                        class="border border-[#C5A47E]/35 bg-[#0C0C10] px-4 py-1.5 font-mono-tech text-[10px] uppercase tracking-[0.22em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                    >
                        ↺ Tourner Gauche
                    </button>
                    <span class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-neutral-500">
                        TOUCHPAD / MOLETTE / GLISSER
                    </span>
                    <button
                        type="button"
                        @click="stepWheel(1)"
                        class="border border-[#C5A47E]/35 bg-[#0C0C10] px-4 py-1.5 font-mono-tech text-[10px] uppercase tracking-[0.22em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                    >
                        Tourner Droite ↻
                    </button>
                </div>
            </div>

            {{-- ============================================================= --}}
            {{-- COLONNE DROITE (5 COLS) : DOSSIER DU MEMBRE ALIGNÉ AU VISEUR  --}}
            {{-- ============================================================= --}}
            <div class="flex flex-col justify-between bg-[#0B0B0E] p-6 sm:p-8 lg:col-span-5">
                <template x-if="activeItem">
                    <div class="flex h-full flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-3 font-mono-tech text-[10px] text-[#C5A47E]">
                                <span x-text="'DOSSIER N° ' + activeItem.num + ' / ' + activeWheelItems.length"></span>
                                <span x-text="activeItem.affinity + '% AFFINITÉ'"></span>
                            </div>

                            {{-- Grand aperçu portrait du membre pointé par la roue --}}
                            <div class="relative mt-4 h-56 w-full overflow-hidden border border-[#C5A47E]/25 bg-black">
                                <img
                                    :src="activeItem.photo"
                                    :alt="activeItem.name"
                                    :class="isUnsealed(activeItem.id)
                                        ? 'grayscale-0 blur-0 scale-100'
                                        : 'grayscale contrast-125 blur-md scale-110 brightness-50'"
                                    class="h-full w-full object-cover transition-all duration-1000"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0B0B0E] via-transparent to-transparent"></div>

                                {{-- Bouton Sceau de Bronze sur la photo si encore scellée --}}
                                <div
                                    x-show="!isUnsealed(activeItem.id)"
                                    class="absolute inset-0 flex flex-col items-center justify-center bg-black/45 p-4 text-center"
                                >
                                    <button
                                        type="button"
                                        @mousedown.prevent="startHoldSeal(activeItem.id, $event)"
                                        @touchstart.prevent="startHoldSeal(activeItem.id, $event)"
                                        :class="holdingId === activeItem.id ? 'seal-holding' : 'hover:scale-105'"
                                        class="border border-[#C5A47E] bg-[#08080A]/90 px-5 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-[0.25em] text-[#C5A47E] shadow-2xl"
                                    >
                                        <span x-text="holdingId === activeItem.id ? 'DESCELLEMENT... ' + holdProgress + '%' : 'MAINTENIR 1,2S POUR DESCELLER'"></span>
                                    </button>
                                </div>

                                <div class="absolute bottom-3 left-4 right-4 flex items-end justify-between">
                                    <div>
                                        <p class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-[#C5A47E]" x-text="activeItem.district + ' • ' + activeItem.intention"></p>
                                        <h2 class="font-serif-luxury text-3xl font-normal italic text-white" x-text="activeItem.name + ', ' + activeItem.age"></h2>
                                    </div>
                                </div>
                            </div>

                            {{-- Objet-Code & Confession secrète --}}
                            <div class="mt-4 border border-[#C5A47E]/20 bg-[#08080A] p-4">
                                <p class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-neutral-500">
                                    PRÉTEXTE DE COUVERTURE : <span class="text-[#C5A47E]" x-text="'« ' + activeItem.codeObject + ' »'"></span>
                                </p>
                                <p
                                    class="font-serif-luxury mt-2 text-base italic leading-relaxed transition-all duration-700"
                                    :class="isUnsealed(activeItem.id) ? 'text-[#EAE6DF]' : 'text-neutral-500 blur-[3px]'"
                                    x-text="activeItem.confession"
                                ></p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-3">
                            <a
                                :href="activeItem.url"
                                class="flex flex-1 items-center justify-center bg-[#C5A47E] px-5 py-3.5 font-mono-tech text-[11px] font-bold uppercase tracking-[0.22em] text-[#08080A] transition hover:bg-[#D8BC98]"
                            >
                                Initier le Rendez-vous →
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- CHAPITRE III : CARTOGRAPHIE RADAR NOCTURNE DE LA VILLE            --}}
        {{-- ================================================================= --}}
        <div
            x-cloak
            x-show="spatialChapter === 'radar'"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="grid flex-1 overflow-hidden lg:grid-cols-12"
        >
            <div class="relative flex items-center justify-center overflow-hidden border-r border-[#C5A47E]/15 bg-[#060608] lg:col-span-8">
                <div class="pointer-events-none relative flex h-[440px] w-[440px] items-center justify-center">
                    <div class="absolute inset-0 rounded-full border border-[#C5A47E]/15"></div>
                    <div class="absolute inset-12 rounded-full border border-dashed border-[#C5A47E]/20"></div>
                    <div class="absolute inset-28 rounded-full border border-[#C5A47E]/25"></div>
                    <div class="absolute inset-44 rounded-full border border-[#C5A47E]/30"></div>
                    <div class="absolute h-px w-full bg-[#C5A47E]/15"></div>
                    <div class="absolute h-full w-px bg-[#C5A47E]/15"></div>
                </div>

                <template x-for="(person, idx) in suitors" :key="person.id">
                    <button
                        type="button"
                        @click="selectedBeaconIdx = idx"
                        :style="'left: ' + person.x + '%; top: ' + person.y + '%;'"
                        class="group absolute -translate-x-1/2 -translate-y-1/2"
                    >
                        <span
                            :class="selectedBeaconIdx === idx ? 'bg-[#C5A47E] scale-150' : 'bg-[#C5A47E]/60'"
                            class="absolute -inset-2 animate-ping rounded-full opacity-50"
                        ></span>
                        <div
                            :class="selectedBeaconIdx === idx
                                ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]'
                                : 'border-[#C5A47E]/60 bg-[#0D0D12] text-[#C5A47E]'"
                            class="relative flex items-center gap-2 border px-3 py-1.5 font-mono-tech text-[10px] font-bold uppercase tracking-widest shadow-2xl transition"
                        >
                            <span x-text="person.num"></span>
                            <span x-text="person.district"></span>
                        </div>
                    </button>
                </template>
            </div>

            <div class="flex flex-col justify-between bg-[#0B0B0E] p-8 lg:col-span-4">
                <div>
                    <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-3 font-mono-tech text-[10px] text-[#C5A47E]">
                        <span x-text="'BALISE N° ' + activeBeacon.num"></span>
                        <span x-html="activeBeacon.coords"></span>
                    </div>

                    <div class="relative mt-5 h-56 w-full overflow-hidden border border-[#C5A47E]/25 bg-black">
                        <img
                            :src="activeBeacon.photo"
                            :alt="activeBeacon.name"
                            :class="isUnsealed(activeBeacon.id) ? 'grayscale-0 blur-0' : 'grayscale blur-sm brightness-75'"
                            class="h-full w-full object-cover transition-all duration-700"
                        >
                        <div
                            x-show="!isUnsealed(activeBeacon.id)"
                            class="absolute inset-0 flex items-center justify-center bg-black/40"
                        >
                            <button
                                type="button"
                                @mousedown.prevent="startHoldSeal(activeBeacon.id, $event)"
                                @touchstart.prevent="startHoldSeal(activeBeacon.id, $event)"
                                class="border border-[#C5A47E] bg-[#08080A]/90 px-4 py-2 font-mono-tech text-[10px] uppercase tracking-widest text-[#C5A47E]"
                            >
                                Maintenir 1,2s pour desceller
                            </button>
                        </div>
                    </div>

                    <h3 class="font-serif-luxury mt-5 text-3xl italic text-white" x-text="activeBeacon.name + ', ' + activeBeacon.age"></h3>
                    <p class="font-mono-tech mt-1 text-[10px] uppercase tracking-[0.2em] text-[#C5A47E]" x-text="activeBeacon.district + ' • ' + activeBeacon.intention"></p>
                    <p class="font-serif-luxury mt-4 text-base italic leading-relaxed text-neutral-300" x-text="activeBeacon.confession"></p>
                </div>

                <a
                    href="{{ route('dashboard') }}"
                    class="mt-6 flex w-full items-center justify-center bg-[#C5A47E] px-5 py-3.5 font-mono-tech text-[11px] font-bold uppercase tracking-[0.22em] text-[#08080A] transition hover:bg-[#D8BC98]"
                >
                    Écrire dans La Loge →
                </a>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- DOCK SPATIAL EN BAS D'ÉCRAN                                       --}}
        {{-- ================================================================= --}}
        <div class="flex items-center justify-between border-t border-[#C5A47E]/20 bg-[#0A0A0E] px-6 py-3">
            <div class="hidden items-center gap-3 font-mono-tech text-[10px] uppercase tracking-[0.25em] text-neutral-500 md:flex">
                <span>MÉCANIQUE HORLOGÈRE</span>
                <span>—</span>
                <span>ROUE ROTATIVE 360°</span>
            </div>

            <div class="mx-auto flex items-center gap-2 sm:mx-0">
                <button
                    type="button"
                    @click="spatialChapter = 'wheel_suitors'; wheelAngle = 0"
                    :class="spatialChapter === 'wheel_suitors'
                        ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]'
                        : 'border-[#C5A47E]/25 bg-transparent text-[#EAE6DF] hover:border-[#C5A47E]'"
                    class="border px-4 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.22em] transition"
                >
                    I. Roue des Courtisans (06)
                </button>

                <button
                    type="button"
                    @click="spatialChapter = 'wheel_archives'; wheelAngle = 0"
                    :class="spatialChapter === 'wheel_archives'
                        ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]'
                        : 'border-[#C5A47E]/25 bg-transparent text-[#EAE6DF] hover:border-[#C5A47E]'"
                    class="border px-4 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.22em] transition"
                >
                    II. Roue des Annonces-Codes (08)
                </button>

                <button
                    type="button"
                    @click="spatialChapter = 'radar'"
                    :class="spatialChapter === 'radar'
                        ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]'
                        : 'border-[#C5A47E]/25 bg-transparent text-[#EAE6DF] hover:border-[#C5A47E]'"
                    class="border px-4 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.22em] transition"
                >
                    III. Radar Topographique
                </button>
            </div>

            <a
                href="{{ route('annonces') }}"
                class="hidden font-mono-tech text-[10px] font-bold uppercase tracking-[0.22em] text-[#C5A47E] hover:underline lg:inline-block"
            >
                Catalogue ↗
            </a>
        </div>
    </div>

</x-layouts.public>
