{{-- resources/views/listings/update.blade.php --}}
<x-layouts.public title="Modifier une pièce | UBERBITE / ARCHIVE">
    <div class="mx-auto w-full max-w-2xl px-6 py-10">
        <div class="mb-8">
            <p
                :class="secretMode ? 'text-rose-400' : 'text-neutral-500'"
                class="font-mono-tech text-xs font-bold uppercase tracking-[0.25em]"
                x-text="secretMode ? 'AJUSTER VOTRE SIGNAL' : 'ÉDITION DE L\'ARCHIVE'"
            >ÉDITION DE L'ARCHIVE</p>
            <h1
                :class="secretMode ? 'text-rose-50 italic' : 'text-[#111111]'"
                class="font-serif-luxury mt-1 text-4xl font-bold tracking-tight sm:text-5xl"
                x-text="secretMode ? 'Modifier votre Prétexte Codé' : 'Modifier l\'Annonce'"
            >Modifier l'Annonce</h1>
        </div>

        <form
            method="POST"
            action="{{ route('listings.update', $listing->slug) }}"
            :class="secretMode
                ? 'rounded-3xl border border-rose-400/30 bg-[#150411] text-rose-50 shadow-2xl shadow-rose-950/50'
                : 'border border-[#DFDDD4] bg-white text-[#111111]'"
            class="space-y-6 p-6 sm:p-10"
        >
            @csrf
            @method('PUT')

            <div>
                <label
                    for="title"
                    :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                    class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    x-text="secretMode ? 'OBJET-CODE (TITRE VISIBLE EN FAÇADE)' : '01 / DÉSIGNATION DE L\'OBJET'"
                >01 / DÉSIGNATION DE L'OBJET</label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $listing->title) }}"
                    :class="secretMode
                        ? 'rounded-xl border-rose-400/25 bg-[#0A0208] text-rose-100 focus:border-rose-400'
                        : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                    class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                >
                @error('title')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label
                        for="category_id"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? 'UNIVERS D\'AFFINITÉ' : '02 / CATÉGORIE'"
                    >02 / CATÉGORIE</label>
                    <select
                        id="category_id"
                        name="category_id"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0A0208] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                    >
                        <option value="">Choisir une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $listing->category_id) == $category->id)>
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
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? 'ÉTAT (CODE DE VOTRE INTENTION)' : '03 / ÉTAT DE CONSERVATION'"
                    >03 / ÉTAT DE CONSERVATION</label>
                    <select
                        id="condition"
                        name="condition"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0A0208] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                    >
                        <option value="">Sélectionner l'état</option>
                        @foreach ($conditions as $condition)
                            <option value="{{ $condition->value }}" @selected(old('condition', $listing->condition->value) === $condition->value)>
                                {{ $condition->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('condition')
                        <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label
                        for="price"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? 'PRIX FAÇADE (€) / INDICE' : '04 / PRIX (€)'"
                    >04 / PRIX (€)</label>
                    <input
                        id="price"
                        type="number"
                        step="0.01"
                        min="0"
                        name="price"
                        value="{{ old('price', $listing->price) }}"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0A0208] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                        class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                    >
                    @error('price')
                        <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="city"
                        :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                        class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                        x-text="secretMode ? 'LIEU DE RENDEZ-VOUS' : '05 / VILLE'"
                    >05 / VILLE</label>
                    <input
                        id="city"
                        type="text"
                        name="city"
                        value="{{ old('city', $listing->city) }}"
                        :class="secretMode
                            ? 'rounded-xl border-rose-400/25 bg-[#0A0208] text-rose-100 focus:border-rose-400'
                            : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
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
                    :class="secretMode ? 'text-rose-300' : 'text-neutral-600'"
                    class="font-mono-tech block text-[11px] font-bold uppercase tracking-wider"
                    x-text="secretMode ? 'MESSAGE À DOUBLE SENS (DESCRIPTION)' : '06 / DESCRIPTION'"
                >06 / DESCRIPTION</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    :class="secretMode
                        ? 'rounded-xl border-rose-400/25 bg-[#0A0208] text-rose-100 focus:border-rose-400'
                        : 'border-[#DFDDD4] bg-[#F6F5F0] text-[#111111] focus:border-[#111111]'"
                    class="mt-2 block w-full border px-4 py-3 text-sm focus:outline-none"
                >{{ old('description', $listing->description) }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div
                :class="secretMode ? 'border-rose-500/20' : 'border-[#DFDDD4]'"
                class="flex items-center justify-end gap-3 border-t pt-5"
            >
                <a
                    href="{{ url('/annonces') }}"
                    :class="secretMode ? 'rounded-xl border-rose-400/30 text-rose-200' : 'border-[#DFDDD4] text-neutral-700 hover:border-[#111111]'"
                    class="border px-5 py-3 text-xs font-bold uppercase tracking-wider transition"
                >
                    Annuler
                </a>
                <button
                    type="submit"
                    :class="secretMode
                        ? 'rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 text-white'
                        : 'bg-[#111111] text-[#F6F5F0] hover:bg-neutral-800'"
                    class="px-7 py-3 text-xs font-bold uppercase tracking-[0.18em] transition"
                >
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</x-layouts.public>
