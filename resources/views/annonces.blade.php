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
    $wheelCatalogItems = $articles->getCollection()
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
                'codeObject' => $art->title,
                'confession' => '« ' . Str::limit($userSecret['bio'] ?? $art->description, 130) . ' »',
                'district' => $art->city ?: ($userSecret['district'] ?? 'Toulouse'),
                'name' => $userSecret['alias'] ?? ($art->user?->name ?? 'Membre Initié'),
                'age' => $userSecret['age'] ?? (24 + ($h % 11)),
                'affinity' => 85 + ($h % 14),
                'photo' => $pool[$idx % count($pool)],
                'intention' => $art->secretRdvLabel(),
                'nocturnalSlot' => $art->secretHourLabel(),
                'url' => route('annonce', ['listing' => $art->slug]),
            ];
        });
@endphp

<x-layouts.public title="Catalogue | UBERBITE / ARCHIVE">

    <div
        x-data="{
            secretLayout: 'wheel', // 'wheel' | 'matrice'
            wheelAngle: 0,
            isDraggingWheel: false,
            dragStartAngle: 0,
            wheelStartAngle: 0,
            allCatalogItems: {{ Js::from($wheelCatalogItems) }},

            // Filtrage dynamique selon l'orientation choisie dans le questionnaire
            get catalogItems() {
                const filtered = this.allCatalogItems.filter(p => this.matchesUserSeeking(p.gender));
                return filtered.length ? filtered : this.allCatalogItems;
            },

            get activeIndex() {
                const count = this.catalogItems.length || 1;
                const step = 360 / count;
                return ((-Math.round(this.wheelAngle / step)) % count + count) % count;
            },
            get activeItem() {
                return this.catalogItems[this.activeIndex] || null;
            },
            onWheelSpin(e) {
                const delta = Math.abs(e.deltaX) > Math.abs(e.deltaY) ? e.deltaX : e.deltaY;
                this.wheelAngle -= delta * 0.32;
            },
            startWheelDrag(e) {
                const rect = this.$refs.catalogWheelDial.getBoundingClientRect();
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
                const rect = this.$refs.catalogWheelDial.getBoundingClientRect();
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
                this.snapToIndex(this.activeIndex);
            },
            snapToIndex(idx) {
                const count = this.catalogItems.length || 1;
                const step = 360 / count;
                const target = -idx * step;
                let diff = ((target - this.wheelAngle + 540) % 360) - 180;
                this.wheelAngle = this.wheelAngle + diff;
            },
            stepWheel(dir) {
                const count = this.catalogItems.length || 1;
                const step = 360 / count;
                this.wheelAngle -= dir * step;
                this.snapToIndex(this.activeIndex);
            },
            getNodeStyle(idx) {
                const count = this.catalogItems.length || 1;
                const step = 360 / count;
                const totalDeg = (idx * step) + this.wheelAngle - 90;
                const rad = totalDeg * (Math.PI / 180);

                const isEjected = this.assemblyStage >= 3;
                const radius = isEjected ? 190 : 0;
                const x = Math.cos(rad) * radius;
                const y = Math.sin(rad) * radius;
                const isSelected = idx === this.activeIndex;
                const scale = !isEjected ? 0.1 : (isSelected ? 1.24 : 0.82);
                const opacity = isEjected ? 1 : 0;
                const zIndex = isSelected ? 30 : 10;

                const staggerDelay = (this.assemblyStage === 3 || this.assemblyStage === 4) ? `${idx * 90}ms` : '0ms';
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
        class="mx-auto max-w-7xl px-6 py-8"
    >
        {{-- En-tête Swiss Editorial (Façade) vs Haute Couture Noir & Bronze (Secret) --}}
        <div
            :class="secretMode
                ? 'border border-[#C5A47E]/30 bg-[#0C0C0F] text-[#EAE6DF]'
                : 'border border-[#DFDDD4] bg-white text-[#111111]'"
            class="relative overflow-hidden px-6 py-7 sm:px-10 sm:py-8 transition-all duration-700"
        >
            <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
                <div>
                    <span
                        :class="secretMode ? 'border-[#C5A47E]/50 text-[#C5A47E]' : 'border-[#111111] text-[#111111]'"
                        class="font-mono-tech inline-flex items-center gap-2 border px-3 py-1 text-[10px] font-bold uppercase tracking-[0.28em]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full" :class="secretMode ? 'bg-[#C5A47E]' : 'bg-[#111111]'"></span>
                        <span x-text="secretMode ? 'FILTRE D\'ORIENTATION : ' + seekingLabel() + ' • VOS ANNONCES SONT MASQUÉES' : 'INDEX GÉNÉRAL — CATALOGUE'"></span>
                    </span>

                    <h1
                        data-cipher-facade="Archive des Pièces"
                        data-cipher-secret="Le Cadran des Courtisans"
                        :class="secretMode ? 'italic text-[#EAE6DF]' : 'text-[#111111]'"
                        class="font-serif-luxury mt-3 text-4xl font-bold tracking-tight sm:text-5xl"
                    >
                        Archive des Pièces
                    </h1>
                </div>

                {{-- Sélecteur d'affichage Roue Horlogère vs Matrice en mode secret --}}
                <div class="flex flex-wrap items-center gap-3">
                    <template x-if="secretMode">
                        <div class="flex items-center border border-[#C5A47E]/30 bg-[#08080A] p-1">
                            <button
                                type="button"
                                @click="secretLayout = 'wheel'"
                                :class="secretLayout === 'wheel' ? 'bg-[#C5A47E] text-[#08080A]' : 'text-[#EAE6DF]/70 hover:text-[#C5A47E]'"
                                class="px-3.5 py-1.5 font-mono-tech text-[10px] font-bold uppercase tracking-[0.2em] transition"
                            >
                                ⟳ Roue Horlogère 360°
                            </button>
                            <button
                                type="button"
                                @click="secretLayout = 'matrice'"
                                :class="secretLayout === 'matrice' ? 'bg-[#C5A47E] text-[#08080A]' : 'text-[#EAE6DF]/70 hover:text-[#C5A47E]'"
                                class="px-3.5 py-1.5 font-mono-tech text-[10px] font-bold uppercase tracking-[0.2em] transition"
                            >
                                ⊞ Matrice 3D
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <section class="py-6" aria-labelledby="annonces-title">
            {{-- BARRE DE FILTRES --}}
            <form
                method="GET"
                action="{{ url()->current() }}"
                :class="secretMode
                    ? 'border border-[#C5A47E]/25 bg-[#0C0C0F]'
                    : 'border border-[#DFDDD4] bg-white'"
                class="mb-8 grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_auto]"
            >
                <div class="min-w-0">
                    <label
                        for="listing-search"
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                        class="font-mono-tech mb-1.5 block text-[10px] font-bold uppercase tracking-[0.2em]"
                        x-text="secretMode ? '01 / MOT-CODE DE COUVERTURE' : '01 / RECHERCHE'"
                    >01 / RECHERCHE</label>
                    <input
                        id="listing-search"
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        :placeholder="secretMode ? 'Ex. Montre, Vélo, Miroir...' : 'Désignation de l’objet...'"
                        :class="secretMode
                            ? 'border-[#C5A47E]/25 bg-[#08080A] text-[#EAE6DF] placeholder:text-neutral-600 focus:border-[#C5A47E]'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] placeholder:text-neutral-400 focus:border-[#111111]'"
                        class="w-full border px-4 py-2.5 text-sm focus:outline-none"
                    >
                </div>

                <div class="min-w-0">
                    <label
                        for="listing-category"
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                        class="font-mono-tech mb-1.5 block text-[10px] font-bold uppercase tracking-[0.2em]"
                        x-text="secretMode ? '02 / TYPE DE RENDEZ-VOUS RECHERCHÉ' : '02 / CATÉGORIE'"
                    >02 / CATÉGORIE</label>
                    <select
                        id="listing-category"
                        name="category"
                        :class="secretMode
                            ? 'border-[#C5A47E]/25 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="w-full border px-4 py-2.5 text-sm focus:outline-none"
                    >
                        <option value="" x-text="secretMode ? 'Tous les types de rendez-vous' : 'Toutes les catégories'">Toutes les catégories</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->slug }}"
                                @selected(request('category') === $category->slug)
                                x-text="secretMode ? '{{ addslashes($category->secretRdvType()) }}' : '{{ addslashes($category->name) }}'"
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-0" x-data="{ priceVal: '{{ request('max_price') }}' }">
                    <label
                        for="listing-max-price"
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                        class="font-mono-tech mb-1.5 block text-[10px] font-bold uppercase tracking-[0.2em]"
                        x-text="secretMode ? '03 / CRÉNEAU & DEGRÉ DE LA NUIT' : '03 / BUDGET MAX (€)'"
                    >03 / BUDGET MAX (€)</label>

                    <div x-show="!secretMode" class="relative">
                        <input
                            id="listing-max-price"
                            type="number"
                            name="max_price"
                            min="0"
                            step="0.01"
                            x-model="priceVal"
                            placeholder="Sans limite"
                            class="w-full border border-[#DFDDD4] bg-[#F6F5F0] px-4 py-2.5 pr-9 text-sm text-[#111111] placeholder:text-neutral-400 focus:border-[#111111] focus:outline-none"
                        >
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center font-mono-tech text-xs text-neutral-500">€</span>
                    </div>

                    <div x-cloak x-show="secretMode">
                        <select
                            @change="priceVal = $event.target.value"
                            class="w-full border border-[#C5A47E]/25 bg-[#08080A] px-4 py-2.5 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                        >
                            <option value="" :selected="!priceVal">Toutes les heures de la nuit</option>
                            <option value="50" :selected="priceVal == '50'">21h00 • Premier Verre Feutré (Degré I)</option>
                            <option value="150" :selected="priceVal == '150'">22h30 • Souper aux Chandelles (Degré II)</option>
                            <option value="400" :selected="priceVal == '400'">23h45 • Confidences de Minuit (Degré III)</option>
                            <option value="5000" :selected="priceVal == '5000'">01h15 • Nuit Blanche & Aube (Degré IV)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-end gap-2">
                    <button
                        type="submit"
                        :class="secretMode
                            ? 'bg-[#C5A47E] text-[#08080A] hover:bg-[#D8BC98]'
                            : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                        class="inline-flex h-[42px] flex-1 items-center justify-center px-6 text-xs font-bold uppercase tracking-[0.2em] transition"
                    >
                        Filtrer
                    </button>
                    @if (request()->hasAny(['q', 'category', 'max_price']))
                        <a
                            href="{{ url()->current() }}"
                            :class="secretMode
                                ? 'border-[#C5A47E]/35 text-[#EAE6DF] hover:border-[#C5A47E]'
                                : 'border-[#111111] text-[#111111] hover:bg-[#F6F5F0]'"
                            class="inline-flex h-[42px] items-center justify-center border px-4 text-xs font-bold uppercase tracking-wider transition"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- ================================================================= --}}
            {{-- AFFICHAGE 1 : ROUE D'HORLOGER ROTATIVE 360° (PAR DÉFAUT EN SECRET)--}}
            {{-- ================================================================= --}}
            <div
                x-cloak
                x-show="secretMode && secretLayout === 'wheel'"
                @wheel.prevent="onWheelSpin($event)"
                class="grid border border-[#C5A47E]/30 bg-[#070709] lg:grid-cols-12"
            >
                <div class="relative flex flex-col items-center justify-center overflow-hidden border-b border-[#C5A47E]/20 p-6 lg:col-span-7 lg:border-b-0 lg:border-r">
                    <div class="pointer-events-none mb-2 flex flex-col items-center">
                        <span class="font-mono-tech text-[9px] uppercase tracking-[0.35em] text-[#C5A47E]">VISEUR • 12H</span>
                        <div class="mt-1 h-3 w-px bg-[#C5A47E]"></div>
                    </div>

                    <div
                        x-ref="catalogWheelDial"
                        @mousedown="startWheelDrag($event)"
                        @touchstart="startWheelDrag($event)"
                        class="relative flex h-[430px] w-[430px] cursor-grab items-center justify-center active:cursor-grabbing sm:h-[460px] sm:w-[460px]"
                    >
                        <div
                            :style="`transform: rotate(${wheelAngle}deg); transition: ${isDraggingWheel ? 'none' : 'transform 0.35s cubic-bezier(0.22, 1, 0.36, 1)'};`"
                            class="pointer-events-none absolute inset-6 rounded-full border border-[#C5A47E]/25"
                        ></div>
                        <div class="pointer-events-none absolute inset-16 rounded-full border border-dashed border-[#C5A47E]/20"></div>
                        <div class="pointer-events-none absolute inset-32 rounded-full border border-[#C5A47E]/15"></div>

                        {{-- Moyeu central : Sceau de Bronze --}}
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
                                    class="relative flex h-28 w-28 flex-col items-center justify-center rounded-full border border-[#C5A47E] bg-[#0B0B0F] text-[#C5A47E] shadow-2xl transition"
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
                                    <span class="font-mono-tech text-[9px] uppercase tracking-widest text-neutral-400" x-text="'LOT 0' + (activeIndex + 1)"></span>
                                    <span class="font-serif-luxury text-2xl italic text-[#EAE6DF]" x-text="activeItem.name.split(' ')[0]"></span>
                                    <span
                                        class="font-mono-tech mt-0.5 text-[8px] uppercase tracking-widest text-[#C5A47E]"
                                        x-text="holdingId === activeItem.id ? holdProgress + '%' : (isUnsealed(activeItem.id) ? '✓ DESCELLÉ' : 'SCEAU')"
                                    ></span>
                                </button>
                            </div>
                        </template>

                        {{-- Médaillons en orbite (Filtrés selon orientation + sans ses propres annonces) --}}
                        <template x-for="(item, idx) in catalogItems" :key="item.id">
                            <div
                                @click.stop="snapToIndex(idx)"
                                :style="getNodeStyle(idx)"
                                class="group absolute left-1/2 top-1/2 cursor-pointer"
                            >
                                <div
                                    :class="idx === activeIndex
                                        ? 'border-2 border-[#C5A47E] shadow-2xl shadow-[#C5A47E]/25'
                                        : 'border border-[#C5A47E]/35 opacity-60 hover:opacity-100'"
                                    class="relative h-20 w-20 overflow-hidden rounded-full bg-[#0D0D11] transition-all duration-300"
                                >
                                    <img
                                        :src="item.photo"
                                        :alt="item.name"
                                        :class="isUnsealed(item.id) ? 'grayscale-0 blur-0' : 'grayscale contrast-125 blur-[2px] brightness-75'"
                                        class="h-full w-full object-cover transition-all duration-700"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-1 inset-x-0 text-center">
                                        <span class="font-mono-tech text-[8px] font-bold text-[#EAE6DF]" x-text="'0' + (idx + 1)"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-3 flex items-center gap-4">
                        <button
                            type="button"
                            @click="stepWheel(-1)"
                            class="border border-[#C5A47E]/35 bg-[#0C0C10] px-4 py-1.5 font-mono-tech text-[10px] uppercase tracking-[0.22em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                        >↺ Précédent</button>
                        <button
                            type="button"
                            @click="stepWheel(1)"
                            class="border border-[#C5A47E]/35 bg-[#0C0C10] px-4 py-1.5 font-mono-tech text-[10px] uppercase tracking-[0.22em] text-[#C5A47E] transition hover:bg-[#C5A47E] hover:text-[#08080A]"
                        >Suivant ↻</button>
                    </div>
                </div>

                {{-- Dossier du membre aligné (5 cols) --}}
                <div class="flex flex-col justify-between bg-[#0B0B0E] p-8 lg:col-span-5">
                    <template x-if="activeItem">
                        <div class="flex h-full flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between border-b border-[#C5A47E]/20 pb-3 font-mono-tech text-[10px] text-[#C5A47E]">
                                    <span x-text="'DOSSIER N° 0' + (activeIndex + 1) + ' / ' + catalogItems.length"></span>
                                    <span x-text="'✓ PROFIL VÉRIFIÉ • ' + activeItem.affinity + '% AFFINITÉ'"></span>
                                </div>

                                <div class="relative mt-4 h-52 w-full overflow-hidden border border-[#C5A47E]/25 bg-black">
                                    <img
                                        :src="activeItem.photo"
                                        :alt="activeItem.name"
                                        :class="isUnsealed(activeItem.id) ? 'grayscale-0 blur-0' : 'grayscale contrast-125 blur-md brightness-50'"
                                        class="h-full w-full object-cover transition-all duration-1000"
                                    >
                                    <div class="absolute right-3 top-3 border border-[#C5A47E]/40 bg-[#08080A]/90 px-2.5 py-1 font-mono-tech text-[9px] uppercase tracking-wider text-[#C5A47E]">
                                        <span x-text="activeItem.nocturnalSlot"></span>
                                    </div>
                                    <div
                                        x-show="!isUnsealed(activeItem.id)"
                                        class="absolute inset-0 flex items-center justify-center bg-black/45 p-4 text-center"
                                    >
                                        <button
                                            type="button"
                                            @mousedown.prevent="startHoldSeal(activeItem.id, $event)"
                                            @touchstart.prevent="startHoldSeal(activeItem.id, $event)"
                                            class="border border-[#C5A47E] bg-[#08080A]/90 px-5 py-2.5 font-mono-tech text-[10px] font-bold uppercase tracking-[0.25em] text-[#C5A47E]"
                                        >
                                            <span x-text="holdingId === activeItem.id ? 'DESCELLEMENT... ' + holdProgress + '%' : 'MAINTENIR 1,2S POUR DESCELLER'"></span>
                                        </button>
                                    </div>
                                </div>

                                <h3 class="font-serif-luxury mt-4 text-3xl italic text-white" x-text="activeItem.name + ', ' + activeItem.age"></h3>
                                <p class="font-mono-tech mt-0.5 text-[10px] uppercase tracking-[0.22em] text-neutral-400" x-text="'📍 ' + activeItem.district"></p>

                                <div class="mt-3 grid grid-cols-2 gap-2.5">
                                    <div class="border border-[#C5A47E]/20 bg-[#08080A] p-3">
                                        <p class="font-mono-tech text-[8px] uppercase tracking-[0.22em] text-neutral-500">TYPE DE RDV RECHERCHÉ</p>
                                        <p class="mt-1 text-xs font-bold text-[#C5A47E]" x-text="activeItem.intention"></p>
                                    </div>
                                    <div class="border border-[#C5A47E]/20 bg-[#08080A] p-3">
                                        <p class="font-mono-tech text-[8px] uppercase tracking-[0.22em] text-neutral-500">CRÉNEAU & DEGRÉ</p>
                                        <p class="mt-1 text-xs font-bold text-[#EAE6DF]" x-text="activeItem.nocturnalSlot"></p>
                                    </div>
                                </div>

                                <div class="mt-3 border border-[#C5A47E]/20 bg-[#08080A] p-3.5">
                                    <p class="font-mono-tech text-[9px] uppercase tracking-[0.25em] text-neutral-500">
                                        MOT-CODE : <span class="text-[#C5A47E]" x-text="activeItem.codeObject"></span>
                                    </p>
                                    <p class="font-serif-luxury mt-1.5 text-sm italic leading-relaxed text-[#EAE6DF]" x-text="activeItem.confession"></p>
                                </div>
                            </div>

                            <button
                                type="button"
                                @click="attemptRendezVous(activeItem.name, activeItem.url)"
                                class="mt-4 flex w-full items-center justify-center bg-[#C5A47E] px-5 py-3.5 font-mono-tech text-[11px] font-bold uppercase tracking-[0.22em] text-[#08080A] transition hover:bg-[#D8BC98]"
                            >
                                <span x-text="(!freeRdvUsed && subscriptionTier === 'free') ? '🎁 Ouvrir avec mon 1er RDV Offert →' : 'Ouvrir le Dossier & Proposer un RDV →'"></span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- ================================================================= --}}
            {{-- AFFICHAGE 2 : GRILLE 3D (EN FAÇADE OU SI OPTION MATRICE CHOISIE)  --}}
            {{-- ================================================================= --}}
            <div
                x-show="!secretMode || secretLayout === 'matrice'"
                class="grid gap-7 md:grid-cols-2 lg:grid-cols-3"
            >
                @foreach ($articles as $idx => $article)
                    @php
                        $uSecret = $article->user?->secretProfile() ?? [];
                        $cardGender = $uSecret['gender'] ?? (($idx % 2 === 0) ? 'femme' : 'homme');
                        $cardPool = $cardGender === 'femme' ? $femalePortraitsPool : $malePortraitsPool;
                        $cardPhoto = $cardPool[$idx % count($cardPool)];
                        $isOwnArticle = $currentUserId && (int) $article->user_id === (int) $currentUserId;
                    @endphp
                    <div x-show="!secretMode || (!{{ $isOwnArticle ? 'true' : 'false' }} && matchesUserSeeking('{{ $cardGender }}'))">
                        <x-article
                            :slug="$article['slug']"
                            :title="$article['title']"
                            :description="$article['description']"
                            :condition="$article->condition->Label()"
                            :price="$article['price']"
                            :author="$uSecret['alias'] ?? ($article->user?->name ?? 'Inconnu')"
                            :categoryName="$article->category?->name"
                            :secretRdvType="$article->secretRdvLabel()"
                            :secretPhoto="$cardPhoto"
                            :secretAge="$uSecret['age'] ?? null"
                        />
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($articles->hasPages())
                <nav
                    :class="secretMode ? 'border-[#C5A47E]/20' : 'border-[#DFDDD4]'"
                    class="mt-10 flex flex-col gap-4 border-t pt-6 sm:flex-row sm:items-center sm:justify-between"
                    aria-label="Pagination des annonces"
                >
                    <p class="font-mono-tech text-xs" :class="secretMode ? 'text-neutral-400' : 'text-neutral-500'">
                        LOT <span class="font-bold">{{ $articles->firstItem() }}–{{ $articles->lastItem() }}</span>
                        SUR <span class="font-bold">{{ $articles->total() }}</span>
                    </p>

                    <div class="flex flex-wrap items-center gap-1.5 font-mono-tech">
                        @if ($articles->onFirstPage())
                            <span aria-disabled="true" class="inline-flex h-10 items-center border border-neutral-500/20 px-3.5 text-xs text-neutral-500">← PRÉC</span>
                        @else
                            <a href="{{ $articles->previousPageUrl() }}" rel="prev" :class="secretMode ? 'border-[#C5A47E]/40 text-[#C5A47E]' : 'border-[#111111] text-[#111111]'" class="inline-flex h-10 items-center border px-3.5 text-xs font-bold transition">← PRÉC</a>
                        @endif

                        @foreach ($articles->getUrlRange(max(1, $articles->currentPage() - 1), min($articles->lastPage(), $articles->currentPage() + 1)) as $page => $url)
                            @if ($page === $articles->currentPage())
                                <span
                                    aria-current="page"
                                    :class="secretMode ? 'bg-[#C5A47E] text-[#08080A]' : 'bg-[#111111] text-[#F6F5F0]'"
                                    class="inline-flex h-10 min-w-10 items-center justify-center px-3.5 text-xs font-bold"
                                >{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" :class="secretMode ? 'border-[#C5A47E]/25 text-[#EAE6DF]' : 'border-[#DFDDD4] bg-white text-[#111111]'" class="inline-flex h-10 min-w-10 items-center justify-center border px-3.5 text-xs font-semibold transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($articles->hasMorePages())
                            <a href="{{ $articles->nextPageUrl() }}" rel="next" :class="secretMode ? 'border-[#C5A47E]/40 text-[#C5A47E]' : 'border-[#111111] text-[#111111]'" class="inline-flex h-10 items-center border px-3.5 text-xs font-bold transition">SUIV →</a>
                        @else
                            <span aria-disabled="true" class="inline-flex h-10 items-center border border-neutral-500/20 px-3.5 text-xs text-neutral-500">SUIV →</span>
                        @endif
                    </div>
                </nav>
            @endif

        </section>
    </div>

</x-layouts.public>
