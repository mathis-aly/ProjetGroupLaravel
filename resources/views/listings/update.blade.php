{{-- resources/views/listings/update.blade.php --}}
<x-layouts.public title="Modifier une annonce">

    <div class="mx-auto w-full max-w-2xl px-6 py-10">
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-teal-950">Modifier l'annonce</h1>
            <p class="mt-1 text-sm text-teal-800/80">Mettez à jour les informations de votre annonce.</p>
        </div>

        <form method="POST" action="{{ route('listings.update', $listing->slug) }}" class="space-y-6 rounded-2xl border border-teal-900/10 bg-white/80 p-6 shadow-lg shadow-teal-900/5 sm:p-8">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-bold text-teal-950">Titre de l'annonce</label>
                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $listing->title) }}"
                    placeholder="Ex. Vélo de course 54 cm"
                    class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-2.5 text-sm text-teal-950 placeholder-teal-900/40 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                >
                @error('title')
                    <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="category_id" class="block text-sm font-bold text-teal-950">Catégorie</label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-2.5 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                    >
                        <option value="">Choisir une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $listing->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="condition" class="block text-sm font-bold text-teal-950">État</label>
                    <select
                        id="condition"
                        name="condition"
                        class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-2.5 text-sm text-teal-950 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                    >
                        <option value="">Sélectionner l'état</option>
                        @foreach ($conditions as $condition)
                            <option value="{{ $condition->value }}" @selected(old('condition', $listing->condition->value) === $condition->value)>
                                {{ $condition->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('condition')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="price" class="block text-sm font-bold text-teal-950">Prix (€)</label>
                    <input
                        id="price"
                        type="number"
                        step="0.01"
                        min="0"
                        name="price"
                        value="{{ old('price', $listing->price) }}"
                        placeholder="0.00"
                        class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-2.5 text-sm text-teal-950 placeholder-teal-900/40 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                    >
                    @error('price')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-bold text-teal-950">Ville</label>
                    <input
                        id="city"
                        type="text"
                        name="city"
                        value="{{ old('city', $listing->city) }}"
                        placeholder="Ex. Toulouse"
                        class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-2.5 text-sm text-teal-950 placeholder-teal-900/40 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                    >
                    @error('city')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-teal-950">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Décrivez votre article en détail (caractéristiques, dimensions, défauts éventuels...)"
                    class="mt-1.5 block w-full rounded-xl border border-teal-900/20 bg-white px-4 py-2.5 text-sm text-teal-950 placeholder-teal-900/40 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                >{{ old('description', $listing->description) }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-teal-900/10 pt-5">
                <a href="{{ url('/annonces') }}" class="rounded-xl border border-teal-900/20 px-4 py-2.5 text-sm font-bold text-teal-900 transition hover:bg-teal-900/5">
                    Annuler
                </a>
                <button type="submit" class="rounded-xl bg-amber-400 px-5 py-2.5 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</x-layouts.public>
