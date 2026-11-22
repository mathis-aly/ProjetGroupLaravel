{{-- resources/views/listings/create.blade.php --}}
<x-layouts.public title="Déposer une pièce | UBERBITE / ARCHIVE">
    <div class="mx-auto w-full max-w-2xl px-6 py-10">
        <div class="mb-8">
            <p
                :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-500'"
                class="font-mono-tech text-xs font-bold uppercase tracking-[0.25em]"
                x-text="secretMode ? 'SIGNAL CODÉ DE MAISON VESPER' : 'INDEXATION D\'UNE NOUVELLE PIÈCE'"
            >INDEXATION D'UNE NOUVELLE PIÈCE</p>
            <h1
                :class="secretMode ? 'text-[#EAE6DF] font-normal italic' : 'text-[#111111]'"
                class="font-serif-luxury mt-1 text-4xl font-bold tracking-tight sm:text-5xl"
                x-text="secretMode ? 'Publier un Prétexte de Rendez-vous' : 'Déposer une Annonce'"
            >Déposer une Annonce</h1>
            <p
                :class="secretMode ? 'text-neutral-400' : 'text-neutral-600'"
                class="mt-2 text-sm"
                x-text="secretMode
                    ? 'Choisissez votre type de rendez-vous, votre créneau nocturne et l’objet-prétexte qui servira de couverture.'
                    : 'Renseignez les spécifications de votre objet pour l’intégrer à l’archive.'"
            ></p>
        </div>

        <form
            method="POST"
            action="{{ route('listings.store') }}"
            :class="secretMode
                ? 'border border-[#C5A47E]/30 bg-[#0C0C0F] text-[#EAE6DF]'
                : 'border border-[#DFDDD4] bg-white text-[#111111]'"
            class="space-y-6 p-6 sm:p-10"
        >
            @csrf

            <div>
                <label
                    for="title"
                    :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                    class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    x-text="secretMode ? '01 / MOT-CODE DE COUVERTURE (OBJET VISIBLE EN FAÇADE)' : '01 / DÉSIGNATION DE L\'OBJET'"
                >01 / DÉSIGNATION DE L'OBJET</label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Ex. Montre chronographe vintage 1968"
                    :class="secretMode
                        ? 'border-[#C5A47E]/25 bg-[#08080A] text-[#EAE6DF] placeholder:text-neutral-600 focus:border-[#C5A47E]'
                        : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] placeholder:text-neutral-400 focus:border-[#111111]'"
                    class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                >
                @error('title')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catégorie (Façade) <-> Type de Rendez-vous recherché (Secret) --}}
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label
                        for="category_id"
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? '02 / TYPE DE RENDEZ-VOUS RECHERCHÉ' : '02 / CATÉGORIE'"
                    >02 / CATÉGORIE</label>
                    <select
                        id="category_id"
                        name="category_id"
                        :class="secretMode
                            ? 'border-[#C5A47E]/25 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                    >
                        <option value="" x-text="secretMode ? 'Choisir le type de rendez-vous' : 'Choisir une catégorie'">Choisir une catégorie</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
                                x-text="secretMode ? '{{ addslashes($category->secretRdvType()) }}' : '{{ addslashes($category->name) }}'"
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="condition"
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? '03 / ENGAGEMENT SOUHAITÉ' : '03 / ÉTAT DE CONSERVATION'"
                    >03 / ÉTAT DE CONSERVATION</label>
                    <select
                        id="condition"
                        name="condition"
                        :class="secretMode
                            ? 'border-[#C5A47E]/25 bg-[#08080A] text-[#EAE6DF] focus:border-[#C5A47E]'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                    >
                        <option value="">Sélectionner</option>
                        @foreach ($conditions as $condition)
                            @php
                                $secretCondLabel = match ($condition->value) {
                                    'new' => 'Première Rencontre & Mystère',
                                    'very_good' => 'Complicité Suivie & Régulière',
                                    'good' => 'Escapade d’un Soir',
                                    'for_parts' => 'Passion Sans Promesse',
                                    default => $condition->label(),
                                };
                            @endphp
                            <option
                                value="{{ $condition->value }}"
                                @selected(old('condition') === $condition->value)
                                x-text="secretMode ? '{{ addslashes($secretCondLabel) }}' : '{{ addslashes($condition->label()) }}'"
                            >
                                {{ $condition->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('condition')
                        <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Prix € (Façade) <-> Créneau & Degré de la Nuit (Secret) --}}
            <div class="grid gap-6 sm:grid-cols-2" x-data="{ priceField: '{{ old('price', 120) }}' }">
                <div>
                    <label
                        for="price"
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? '04 / CRÉNEAU & DEGRÉ DE LA NUIT' : '04 / PRIX (€)'"
                    >04 / PRIX (€)</label>

                    {{-- Champ Prix (€) visible uniquement en Façade --}}
                    <div x-show="!secretMode">
                        <input
                            id="price"
                            type="number"
                            step="0.01"
                            min="0"
                            name="price"
                            x-model="priceField"
                            placeholder="0.00"
                            class="mt-2 block w-full border border-[#DFDDD4] bg-[#F6F5F0] px-4 py-3 text-sm text-[#111111] placeholder:text-neutral-400 focus:border-[#111111] focus:outline-none"
                        >
                    </div>

                    {{-- Sélecteur de Créneau Nocturne visible en Mode Secret (alimente priceField automatiquement) --}}
                    <div x-cloak x-show="secretMode">
                        <select
                            @change="priceField = $event.target.value"
                            class="mt-2 block w-full border border-[#C5A47E]/25 bg-[#08080A] px-4 py-3 text-sm text-[#EAE6DF] focus:border-[#C5A47E] focus:outline-none"
                        >
                            <option value="45" :selected="priceField <= 50">21h00 • Premier Verre Feutré (Degré I)</option>
                            <option value="120" :selected="priceField > 50 && priceField <= 150">22h30 • Souper aux Chandelles (Degré II)</option>
                            <option value="280" :selected="priceField > 150 && priceField <= 400">23h45 • Confidences de Minuit (Degré III)</option>
                            <option value="650" :selected="priceField > 400">01h15 • Nuit Blanche & Aube (Degré IV)</option>
                        </select>
                    </div>

                    @error('price')
                        <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="city"
                        :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? '05 / QUARTIER DE RENDEZ-VOUS' : '05 / VILLE'"
                    >05 / VILLE</label>
                    <input
                        id="city"
                        type="text"
                        name="city"
                        value="{{ old('city') }}"
                        placeholder="Ex. Toulouse — Saint-Étienne"
                        :class="secretMode
                            ? 'border-[#C5A47E]/25 bg-[#08080A] text-[#EAE6DF] placeholder:text-neutral-600 focus:border-[#C5A47E]'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] placeholder:text-neutral-400 focus:border-[#111111]'"
                        class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                    >
                    @error('city')
                        <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label
                    for="description"
                    :class="secretMode ? 'text-[#C5A47E]' : 'text-neutral-600'"
                    class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    x-text="secretMode ? '06 / MESSAGE À DOUBLE SENS & CONFESSION' : '06 / DESCRIPTION'"
                >06 / DESCRIPTION</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Rédigez votre texte..."
                    :class="secretMode
                        ? 'border-[#C5A47E]/25 bg-[#08080A] text-[#EAE6DF] placeholder:text-neutral-600 focus:border-[#C5A47E]'
                        : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] placeholder:text-neutral-400 focus:border-[#111111]'"
                    class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div
                :class="secretMode ? 'border-[#C5A47E]/20' : 'border-[#DFDDD4]'"
                class="flex items-center justify-end gap-3 border-t pt-5"
            >
                <a
                    href="{{ url('/annonces') }}"
                    :class="secretMode ? 'border-[#C5A47E]/30 text-[#EAE6DF]' : 'border-[#DFDDD4] text-neutral-700 hover:border-[#111111]'"
                    class="border px-5 py-3 text-xs font-bold uppercase tracking-wider transition"
                >
                    Annuler
                </a>
                <button
                    type="submit"
                    :class="secretMode
                        ? 'bg-[#C5A47E] text-[#08080A] hover:bg-[#D8BC98]'
                        : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                    class="px-7 py-3 font-mono-tech text-xs font-bold uppercase tracking-[0.2em] transition"
                    x-text="secretMode ? 'Sceller & Diffuser le Signal' : 'Publier l\'Annonce'"
                >
                    Publier l'Annonce
                </button>
            </div>
        </form>
    </div>
</x-layouts.public>
