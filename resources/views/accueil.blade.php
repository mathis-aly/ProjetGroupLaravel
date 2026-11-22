@php
    $femalePortraitsPool = [
        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&fit=crop&w=1000&q=85',
    ];

    $malePortraitsPool = [
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=1000&q=85',
        'https://images.unsplash.com/photo-1463453091185-61582044d556?auto=format&fit=crop&w=1000&q=85',
    ];

    $currentUserId = auth()->id();

    // On exclut strictement les propres annonces de l'utilisateur connecté dans la Roue
    $decodedArticles = $articles
        ->filter(fn ($art) => ! $currentUserId || (int) $art->user_id !== (int) $currentUserId)
        ->values()
        ->map(function ($art, $idx) use ($femalePortraitsPool, $malePortraitsPool) {
            $h = abs(crc32((string) $art->slug));
            $userSecret = $art->user?->secretProfile() ?? [];
            $gender = $userSecret['gender'] ?? (($idx % 2 === 0) ? 'femme' : 'homme');
            $pool = $gender === 'femme' ? $femalePortraitsPool : $malePortraitsPool;

            return [
                'id' => 'card-' . $art->slug,
                'num' => sprintf('%02d', $idx + 1),
                'slug' => $art->slug,
                'gender' => $gender,
                'title' => $art->title,
                'codeObject' => $art->title,
                'description' => $art->description,
                'confession' => '« ' . Str::limit($userSecret['bio'] ?? $art->description, 130) . ' »',
                'nocturnalSlot' => $art->secretHourLabel(),
                'district' => $art->city ?: ($userSecret['district'] ?? 'Toulouse Centre'),
                'name' => $userSecret['alias'] ?? ($art->user?->name ?? 'Membre Initié'),
                'age' => $userSecret['age'] ?? (24 + ($h % 11)),
                'affinity' => 86 + ($h % 13),
                'photo' => $pool[$idx % count($pool)],
                'intention' => $art->secretRdvLabel(),
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
                            :categoryName="$article->category?->name"
                            :secretRdvType="$article->secretRdvLabel()"
                        />
                    @endforeach
                </div>
            </section>
        </div>
    </div>

    {{-- ======================================================================= --}}
    {{-- MODE 2 : MAISON VESPER — ROUE 360° FILTRÉE PAR ORIENTATION              --}}
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

            allSuitors: [
                // 6 Partenaires Femmes
                {
                    id: 'deck-eleonore',
                    num: '01',
                    gender: 'femme',
                    name: 'Éléonore V.',
                    age: 28,
                    district: 'Saint-Étienne',
                    coords: '43°35\'58&quot;N 01°26\'59&quot;E',
                    x: 62,
                    y: 48,
                    affinity: 98,
                    intention: 'Bar Clandestin & Grands Crus',
                    nocturnalSlot: '22h30 • Souper Feutré (Degré II)',
                    codeObject: 'Montre mécanique Lip 1968',
                    confession: '« Retrouvez-moi au fond du club de jazz rue des Filatiers à 22h30. Demandez si la montre retarde... »',
                    photo: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-soline',
                    num: '02',
                    gender: 'femme',
                    name: 'Soline D.',
                    age: 26,
                    district: 'Capitole',
                    coords: '43°36\'16&quot;N 01°26\'38&quot;E',
                    x: 52,
                    y: 34,
                    affinity: 94,
                    intention: 'Suite Privée & Hôtel Particulier',
                    nocturnalSlot: '01h15 • Jusqu’à l’Aube (Degré IV)',
                    codeObject: 'Miroir vénitien doré XVIIIe',
                    confession: '« Sensible à l’élégance sobre, à l’ironie et aux regards qui savent garder un secret. »',
                    photo: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-celeste',
                    num: '03',
                    gender: 'femme',
                    name: 'Céleste L.',
                    age: 27,
                    district: 'Jardin Royal',
                    coords: '43°35\'37&quot;N 01°27\'04&quot;E',
                    x: 72,
                    y: 72,
                    affinity: 96,
                    intention: 'Salon Littéraire & Heure Tardive',
                    nocturnalSlot: '23h45 • Heure de Minuit (Degré III)',
                    codeObject: 'Recueil Édition Originale 1924',
                    confession: '« Deux coupes de champagne brut, une bibliothèque silencieuse et toute la nuit devant nous. »',
                    photo: 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-claire',
                    num: '04',
                    gender: 'femme',
                    name: 'Clara M.',
                    age: 29,
                    district: 'Les Carmes',
                    coords: '43°35\'50&quot;N 01°26\'41&quot;E',
                    x: 45,
                    y: 58,
                    affinity: 93,
                    intention: 'Gala, Opéra & Soirée Habillée',
                    nocturnalSlot: '21h00 • Premier Verre (Degré I)',
                    codeObject: 'Parfum Ambré Flacon Cristal',
                    confession: '« Une loge à l’opéra suivie d’un souper tardif loin du tumulte. »',
                    photo: 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-ines',
                    num: '05',
                    gender: 'femme',
                    name: 'Inès K.',
                    age: 25,
                    district: 'Saint-Cyprien',
                    coords: '43°35\'52&quot;N 01°25\'59&quot;E',
                    x: 31,
                    y: 49,
                    affinity: 91,
                    intention: 'Virée Nocturne & Évasion',
                    nocturnalSlot: '23h45 • Heure de Minuit (Degré III)',
                    codeObject: 'Gants de conduite en cuir',
                    confession: '« Partir sur un coup de tête voir la mer de nuit et revenir à l’aube. »',
                    photo: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-apollonie',
                    num: '06',
                    gender: 'femme',
                    name: 'Apolline R.',
                    age: 30,
                    district: 'Bourse',
                    coords: '43°36\'02&quot;N 01°26\'31&quot;E',
                    x: 55,
                    y: 42,
                    affinity: 95,
                    intention: 'Alchimie Intense & Sans Filtre',
                    nocturnalSlot: '01h15 • Jusqu’à l’Aube (Degré IV)',
                    codeObject: 'Briquet Or Brossé 1970',
                    confession: '« Je ne crois qu’aux coups de foudre silencieux au milieu d’une salle bondée. »',
                    photo: 'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },

                // 6 Partenaires Hommes
                {
                    id: 'deck-gabriel',
                    num: '07',
                    gender: 'homme',
                    name: 'Gabriel M.',
                    age: 32,
                    district: 'Les Carmes',
                    coords: '43°35\'49&quot;N 01°26\'39&quot;E',
                    x: 48,
                    y: 62,
                    affinity: 95,
                    intention: 'Club de Jazz & Nuit Électrique',
                    nocturnalSlot: '23h45 • Heure de Minuit (Degré III)',
                    codeObject: 'Vinyle Miles Davis — Kind of Blue',
                    confession: '« J’aime les rencontres qui commencent à minuit sur les quais de la Garonne autour d’un vieux single malt. »',
                    photo: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-julian',
                    num: '08',
                    gender: 'homme',
                    name: 'Julian R.',
                    age: 31,
                    district: 'Saint-Cyprien',
                    coords: '43°35\'54&quot;N 01°25\'52&quot;E',
                    x: 28,
                    y: 54,
                    affinity: 91,
                    intention: 'Souper Clandestin à Huis Clos',
                    nocturnalSlot: '21h00 • Premier Verre (Degré I)',
                    codeObject: 'Boîtier Argentique Leica M3',
                    confession: '« Chef privé, je dresse ce soir une table confidentielle pour deux personnes seulement. »',
                    photo: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-maxime',
                    num: '09',
                    gender: 'homme',
                    name: 'Maxime H.',
                    age: 34,
                    district: 'Bourse',
                    coords: '43°36\'04&quot;N 01°26\'28&quot;E',
                    x: 42,
                    y: 44,
                    affinity: 92,
                    intention: 'Virée Nocturne & Évasion',
                    nocturnalSlot: '01h15 • Jusqu’à l’Aube (Degré IV)',
                    codeObject: 'Briquet Dupont Laque de Chine',
                    confession: '« Collectionneur d’instants rares. Si vous avez du feu, j’ai le reste de la nuit. »',
                    photo: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-adriano',
                    num: '10',
                    gender: 'homme',
                    name: 'Adriano V.',
                    age: 30,
                    district: 'Saint-Étienne',
                    coords: '43°35\'59&quot;N 01°27\'01&quot;E',
                    x: 66,
                    y: 41,
                    affinity: 96,
                    intention: 'Bar Clandestin & Grands Crus',
                    nocturnalSlot: '22h30 • Souper Feutré (Degré II)',
                    codeObject: 'Carafe en Cristal de Bohême',
                    confession: '« Amateur d’architecture et de grands bourgognes. Je connais une cour secrète ouverte après 23h. »',
                    photo: 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-soren',
                    num: '11',
                    gender: 'homme',
                    name: 'Sacha D.',
                    age: 28,
                    district: 'Capitole',
                    coords: '43°36\'15&quot;N 01°26\'35&quot;E',
                    x: 51,
                    y: 29,
                    affinity: 90,
                    intention: 'Salon Littéraire & Heure Tardive',
                    nocturnalSlot: '23h45 • Heure de Minuit (Degré III)',
                    codeObject: 'Échiquier en Palissandre',
                    confession: '« Une partie d’échecs à minuit, un verre de rhum ambré et aucune montre au poignet. »',
                    photo: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                },
                {
                    id: 'deck-balthazar',
                    num: '12',
                    gender: 'homme',
                    name: 'Balthazar L.',
                    age: 35,
                    district: 'Jardin Royal',
                    coords: '43°35\'35&quot;N 01°27\'02&quot;E',
                    x: 75,
                    y: 66,
                    affinity: 94,
                    intention: 'Suite Privée & Hôtel Particulier',
                    nocturnalSlot: '01h15 • Jusqu’à l’Aube (Degré IV)',
                    codeObject: 'Clé d’Hôtel Particulier Ancienne',
                    confession: '« La discrétion est la forme suprême du luxe. »',
                    photo: 'https://images.unsplash.com/photo-1463453091185-61582044d556?auto=format&fit=crop&w=1000&q=85',
                    url: '{{ route('dashboard') }}'
                }
            ],

            decodedList: {{ Js::from($decodedArticles) }},

            // Filtrage dynamique selon l'orientation répondue dans le questionnaire
            get suitors() {
                const filtered = this.allSuitors.filter(p => this.matchesUserSeeking(p.gender));
                return filtered.length ? filtered : this.allSuitors;
            },

            get filteredDecodedList() {
                const filtered = this.decodedList.filter(p => this.matchesUserSeeking(p.gender));
                return filtered.length ? filtered : this.decodedList;
            },

            get activeWheelItems() {
                return this.spatialChapter === 'wheel_archives' ? this.filteredDecodedList : this.suitors;
            },

            get activeIndex() {
                const count = this.activeWheelItems.length || 1;
                const step = 360 / count;
                return ((-Math.round(this.wheelAngle / step)) % count + count) % count;
            },

            get activeItem() {
                return this.activeWheelItems[this.activeIndex] || this.activeWheelItems[0];
            },

            get activeBeacon() {
                return this.suitors[this.selectedBeaconIdx] || this.suitors[0];
            },

            onWheelSpin(e) {
                const delta = Math.abs(e.deltaX) > Math.abs(e.deltaY) ? e.deltaX : e.deltaY;
                this.wheelAngle -= delta * 0.32;
            },

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

            getNodeStyle(idx) {
                const count = this.activeWheelItems.length || 1;
                const step = 360 / count;
                const totalDeg = (idx * step) + this.wheelAngle - 90;
                const rad = totalDeg * (Math.PI / 180);

                const isEjected = this.assemblyStage >= 3;
                const radius = isEjected ? 185 : 0;
                const x = Math.cos(rad) * radius;
                const y = Math.sin(rad) * radius;
                const isSelected = idx === this.activeIndex;
                const scale = !isEjected ? 0.1 : (isSelected ? 1.22 : 0.88);
                const opacity = isEjected ? 1 : 0;
                const zIndex = isSelected ? 30 : 10;

                const staggerDelay = (this.assemblyStage === 3 || this.assemblyStage === 4) ? `${idx * 120}ms` : '0ms';
                const transitionCurve = this.isDraggingWheel
                    ? 'none'
                    : `transform 0.65s cubic-bezier(0.34, 1.42, 0.64, 1) ${staggerDelay}, opacity 0.45s ease ${staggerDelay}`;

                return `transform: translate(calc(-50% + ${x.toFixed(1)}px), calc(-50% + ${y.toFixed(1)}px)) scale(${scale}); opacity: ${opacity}; z-index: ${zIndex}; transition: ${transitionCurve};`;
            }
        }"
        @mousemove.window="moveWheelDrag($event)"
        @mouseup.window="stopWheelDrag()"
        @touchmove.window="moveWheelDrag($event)"
        @touchend.window="stopWheelDrag()"
        class="relative flex h-[calc(100vh-4.1rem)] w-full flex-col justify-between overflow-hidden bg-[#08080A] select-none"
    >
        {{-- BARRE SUPÉRIEURE DE COORDONNÉES & FILTRE DU QUESTIONNAIRE --}}
        <div
            :class="assemblyStage >= 4 ? 'translate-y-0 opacity-100' : '-translate-y-6 opacity-0'"
            class="flex items-center justify-between border-b border-[#C5A47E]/15 px-6 py-2.5 text-[10px] font-mono-tech uppercase tracking-[0.28em] text-[#C5A47E]/80 transition-all duration-700"
        >
            <div class="flex items-center gap-4">
                <span>CADRAN VESPER</span>
                <span class="text-white/20">|</span>
                <span>PARTENAIRES AFFICHÉS : <strong class="text-[#EAE6DF]" x-text="seekingLabel()"></strong></span>
                <button
                    type="button"
                    @click="onboardingStep = 1; showOnboardingModal = true"
                    class="border border-[#C5A47E]/40 bg-[#C5A47E]/10 px-2 py-0.5 text-[9px] text-[#C5A47E] hover:bg-[#C5A47E] hover:text-[#08080A]"
                >Modifier</button>
            </div>

            <div class="flex items-center gap-5">
                <span x-show="!freeRdvUsed && subscriptionTier === 'free'" class="text-emerald-400 font-bold">🎁 1ER RENDEZ-VOUS OFFERT DISPONIBLE</span>
                <span x-show="freeRdvUsed && subscriptionTier === 'free'" class="text-[#C5A47E]">1ER RDV UTILISÉ • <button type="button" @click="showSubscriptionModal = true" class="underline">ACTIVER UN PASS</button></span>
                <span x-show="subscriptionTier !== 'free'" class="text-[#C5A47E] font-bold">👑 PASS ILLIMITÉ ACTIF</span>
                <span class="hidden sm:inline text-white/20">|</span>
                <button
                    type="button"
                    @click="startAssemblyChoreography()"
                    class="hidden md:inline text-[#C5A47E] underline underline-offset-4 hover:text-white"
                >⟳ Rejouer Calibrage</button>
            </div>
        </div>

        {{-- CHAPITRES I & II : LA ROUE D'HORLOGER INTERACTIVE + DOSSIER --}}
        <div
            x-show="spatialChapter === 'wheel_suitors' || spatialChapter === 'wheel_archives'"
            @wheel.prevent="onWheelSpin($event)"
            class="grid flex-1 overflow-hidden lg:grid-cols-12"
        >
            {{-- COLONNE GAUCHE (7 COLS) : LA ROUE MÉCANIQUE ROTATIVE 360° --}}
            <div class="relative flex flex-col items-center justify-center overflow-hidden bg-[#060608] p-4 lg:col-span-7">
                <div
                    :class="assemblyStage >= 2 ? 'scale-y-100' : 'scale-y-0'"
                    class="line-draw-y pointer-events-none absolute bottom-0 right-0 top-0 hidden w-px bg-[#C5A47E]/25 lg:block"
                ></div>

                <div
                    :class="assemblyStage >= 2 ? 'scale-x-100 opacity-100' : 'scale-x-0 opacity-0'"
                    class="line-draw-x pointer-events-none absolute inset-x-12 top-1/2 h-px bg-[#C5A47E]/10"
                ></div>

                <div
                    :class="assemblyStage >= 2 ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-4'"
                    class="pointer-events-none absolute top-4 z-30 flex flex-col items-center transition-all duration-700"
                >
                    <span class="font-mono-tech text-[9px] uppercase tracking-[0.35em] text-[#C5A47E]">VISEUR ACTIF</span>
                    <div class="mt-1 h-4 w-px bg-[#C5A47E]"></div>
                    <div class="h-2 w-2 rotate-45 border-b border-r border-[#C5A47E]"></div>
                </div>

                <div
                    x-ref="wheelDial"
                    @mousedown="startWheelDrag($event)"
                    @touchstart="startWheelDrag($event)"
                    class="relative flex h-[430px] w-[430px] cursor-grab items-center justify-center active:cursor-grabbing sm:h-[470px] sm:w-[470px]"
                >
                    <div
                        x-show="assemblyStage === 1 || assemblyStage === 2"
                        class="vault-shockwave pointer-events-none absolute h-32 w-32 rounded-full border-2 border-[#C5A47E]"
                    ></div>

                    <div
                        :class="assemblyStage >= 2 ? 'scale-100 opacity-100' : 'scale-50 opacity-0'"
                        :style="`transform: rotate(${wheelAngle}deg) scale(${assemblyStage >= 2 ? 1 : 0.4}); transition: ${isDraggingWheel ? 'none' : 'transform 0.7s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.6s ease'};`"
                        class="pointer-events-none absolute inset-6 rounded-full border border-[#C5A47E]/25"
                    >
                        <span class="absolute -top-1.5 left-1/2 h-3 w-px -translate-x-1/2 bg-[#C5A47E]"></span>
                        <span class="absolute -bottom-1.5 left-1/2 h-3 w-px -translate-x-1/2 bg-[#C5A47E]/50"></span>
                        <span class="absolute left-0 top-1/2 h-px w-3 -translate-y-1/2 bg-[#C5A47E]/50"></span>
                        <span class="absolute right-0 top-1/2 h-px w-3 -translate-y-1/2 bg-[#C5A47E]/50"></span>
                    </div>

                    <div
                        :class="assemblyStage >= 2 ? 'scale-100 opacity-100' : 'scale-50 opacity-0'"
                        class="pointer-events-none absolute inset-16 rounded-full border border-dashed border-[#C5A47E]/20 transition-all duration-700 delay-100"
                    ></div>
                    <div
                        :class="assemblyStage >= 2 ? 'scale-100 opacity-100' : 'scale-50 opacity-0'"
                        class="pointer-events-none absolute inset-32 rounded-full border border-[#C5A47E]/15 transition-all duration-700 delay-150"
                    ></div>

                    {{-- MOYEU CENTRAL --}}
                    <template x-if="activeItem">
                        <div
                            x-show="assemblyStage >= 1"
                            :class="assemblyStage === 1 ? 'vault-hub-spin' : ''"
                            class="relative z-20 flex flex-col items-center justify-center text-center"
                        >
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
                                <span class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-neutral-400" x-text="'N° ' + (activeIndex + 1)"></span>
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

                    {{-- LES MÉDAILLONS PORTRAITS (Filtrés selon l'orientation + Sans ses propres annonces) --}}
                    <template x-for="(item, idx) in activeWheelItems" :key="item.id">
                        <div
                            @click.stop="snapToIndex(idx)"
                            :style="getNodeStyle(idx)"
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
                                    <span class="font-mono-tech text-[9px] font-bold uppercase tracking-wider text-[#EAE6DF]" x-text="'0' + (idx + 1)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div
                    :class="assemblyStage >= 4 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                    class="mt-2 flex items-center gap-4 transition-all duration-700"
                >
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

            {{-- COLONNE DROITE (5 COLS) : DOSSIER DU MEMBRE ALIGNÉ AU VISEUR --}}
            <div
                :class="assemblyStage >= 4 ? 'translate-x-0 opacity-100' : 'translate-x-12 opacity-0'"
                class="flex flex-col justify-between bg-[#0B0B0E] p-6 transition-all duration-700 sm:p-8 lg:col-span-5"
            >
                <template x-if="activeItem">
                    <div class="flex h-full flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-3 font-mono-tech text-[10px] text-[#C5A47E]">
                                <span x-text="'DOSSIER N° 0' + (activeIndex + 1) + ' / 0' + activeWheelItems.length"></span>
                                <span x-text="'✓ PROFIL VÉRIFIÉ • ' + activeItem.affinity + '% AFFINITÉ'"></span>
                            </div>

                            <div class="relative mt-4 h-52 w-full overflow-hidden border border-[#C5A47E]/25 bg-black">
                                <img
                                    :src="activeItem.photo"
                                    :alt="activeItem.name"
                                    :class="isUnsealed(activeItem.id)
                                        ? 'grayscale-0 blur-0 scale-100'
                                        : 'grayscale contrast-125 blur-md scale-110 brightness-50'"
                                    class="h-full w-full object-cover transition-all duration-1000"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0B0B0E] via-transparent to-transparent"></div>

                                <div class="absolute right-3 top-3 border border-[#C5A47E]/40 bg-[#08080A]/90 px-3 py-1 font-mono-tech text-[9px] uppercase tracking-wider text-[#C5A47E] backdrop-blur-md">
                                    <span x-text="activeItem.nocturnalSlot"></span>
                                </div>

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
                                        <p class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-[#C5A47E]" x-text="activeItem.district"></p>
                                        <h2 class="font-serif-luxury text-3xl font-normal italic text-white" x-text="activeItem.name + ', ' + activeItem.age"></h2>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 grid grid-cols-2 gap-2.5">
                                <div class="border border-[#C5A47E]/20 bg-[#08080A] p-3">
                                    <p class="font-mono-tech text-[8px] uppercase tracking-[0.25em] text-neutral-500">TYPE DE RDV RECHERCHÉ</p>
                                    <p class="mt-1 text-xs font-bold text-[#C5A47E]" x-text="activeItem.intention"></p>
                                </div>
                                <div class="border border-[#C5A47E]/20 bg-[#08080A] p-3">
                                    <p class="font-mono-tech text-[8px] uppercase tracking-[0.25em] text-neutral-500">CRÉNEAU & DEGRÉ</p>
                                    <p class="mt-1 text-xs font-bold text-[#EAE6DF]" x-text="activeItem.nocturnalSlot"></p>
                                </div>
                            </div>

                            <div class="mt-3 border border-[#C5A47E]/20 bg-[#08080A] p-3.5">
                                <p class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-neutral-500">
                                    MOT-CODE DE COUVERTURE : <span class="text-[#C5A47E]" x-text="'« ' + activeItem.codeObject + ' »'"></span>
                                </p>
                                <p
                                    class="font-serif-luxury mt-1.5 text-sm italic leading-relaxed transition-all duration-700"
                                    :class="isUnsealed(activeItem.id) ? 'text-[#EAE6DF]' : 'text-neutral-500 blur-[3px]'"
                                    x-text="activeItem.confession"
                                ></p>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center gap-3">
                            <button
                                type="button"
                                @click="attemptRendezVous(activeItem.name, activeItem.url)"
                                class="flex flex-1 items-center justify-center bg-[#C5A47E] px-5 py-3 font-mono-tech text-[11px] font-bold uppercase tracking-[0.22em] text-[#08080A] transition hover:bg-[#D8BC98]"
                            >
                                <span x-text="(!freeRdvUsed && subscriptionTier === 'free')
                                    ? '🎁 Initier mon 1er Rendez-vous Offert →'
                                    : 'Initier le Rendez-vous →'"></span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- CHAPITRE III : CARTOGRAPHIE RADAR NOCTURNE DE LA VILLE --}}
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
                            <span x-text="'0' + (idx + 1)"></span>
                            <span x-text="person.district"></span>
                        </div>
                    </button>
                </template>
            </div>

            <div class="flex flex-col justify-between bg-[#0B0B0E] p-8 lg:col-span-4">
                <div>
                    <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-3 font-mono-tech text-[10px] text-[#C5A47E]">
                        <span x-text="'BALISE N° 0' + (selectedBeaconIdx + 1)"></span>
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
                    <p class="font-mono-tech mt-1 text-[10px] uppercase tracking-[0.2em] text-neutral-400" x-text="activeBeacon.nocturnalSlot"></p>
                    <p class="font-serif-luxury mt-4 text-base italic leading-relaxed text-neutral-300" x-text="activeBeacon.confession"></p>
                </div>

                <button
                    type="button"
                    @click="attemptRendezVous(activeBeacon.name, '{{ route('dashboard') }}')"
                    class="mt-6 flex w-full items-center justify-center bg-[#C5A47E] px-5 py-3.5 font-mono-tech text-[11px] font-bold uppercase tracking-[0.22em] text-[#08080A] transition hover:bg-[#D8BC98]"
                >
                    <span x-text="(!freeRdvUsed && subscriptionTier === 'free') ? '🎁 Utiliser mon 1er RDV Offert →' : 'Écrire dans La Loge →'"></span>
                </button>
            </div>
        </div>

        {{-- DOCK SPATIAL EN BAS D'ÉCRAN --}}
        <div
            :class="assemblyStage >= 4 ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'"
            class="flex items-center justify-between border-t border-[#C5A47E]/20 bg-[#0A0A0E] px-6 py-3 transition-all duration-700"
        >
            <div class="hidden items-center gap-3 font-mono-tech text-[10px] uppercase tracking-[0.25em] text-neutral-500 md:flex">
                <span>FILTRE ACTIF : <strong class="text-[#C5A47E]" x-text="seekingLabel()"></strong></span>
                <span>—</span>
                <span>VOS PROPRES ANNONCES SONT MASQUÉES</span>
            </div>

            <div class="mx-auto flex items-center gap-2 sm:mx-0">
                <button
                    type="button"
                    @click="spatialChapter = 'wheel_suitors'; wheelAngle = 0; startAssemblyChoreography()"
                    :class="spatialChapter === 'wheel_suitors'
                        ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]'
                        : 'border-[#C5A47E]/25 bg-transparent text-[#EAE6DF] hover:border-[#C5A47E]'"
                    class="border px-4 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.22em] transition"
                >
                    I. Roue des Courtisans (<span x-text="suitors.length"></span>)
                </button>

                <button
                    type="button"
                    @click="spatialChapter = 'wheel_archives'; wheelAngle = 0; startAssemblyChoreography()"
                    :class="spatialChapter === 'wheel_archives'
                        ? 'border-[#C5A47E] bg-[#C5A47E] text-[#08080A]'
                        : 'border-[#C5A47E]/25 bg-transparent text-[#EAE6DF] hover:border-[#C5A47E]'"
                    class="border px-4 py-2 font-mono-tech text-[10px] font-bold uppercase tracking-[0.22em] transition"
                >
                    II. Roue des Annonces-Codes (<span x-text="filteredDecodedList.length"></span>)
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
