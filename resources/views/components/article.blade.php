@props(['slug', 'title', 'description', 'condition', 'price', 'author', 'canEdit' => false])
<div class="flex h-full flex-col gap-3 rounded-2xl">
    <a href="{{ route('annonce', ['listing' => $slug]) }}" class="block h-full">
        <article class="flex h-[22rem] flex-col overflow-hidden rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5 transition hover:-translate-y-0.5 hover:shadow-xl">
            <p class="mb-3 inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-teal-900">
                Article #{{ $slug }}
            </p>

            <h2 title="{{ $title }}" class="line-clamp-2 min-h-[4rem] text-2xl font-extrabold tracking-tight text-teal-900">
                {{ $title }}
            </h2>

            <p class="mt-3 h-7 flex-none text-xl font-bold text-teal-900">
                {{ number_format((float) $price, 2, ',', ' ') }} €
            </p>

            <p title="{{ $description }}" class="mt-3 line-clamp-3 min-h-[5.25rem] leading-7 text-teal-900/75">
                {{ $description }}
            </p>

            <div class="mt-auto space-y-2 border-t border-teal-900/10 pt-3">
                <p title="{{ $author }}" class="flex min-w-0 items-center gap-3">
                    <span class="w-16 shrink-0 text-[11px] font-bold uppercase text-teal-700">Auteur</span>
                    <span class="truncate text-sm font-semibold text-teal-950">{{ $author }}</span>
                </p>
                <p title="{{ $condition }}" class="flex min-w-0 items-center gap-3">
                    <span class="w-16 shrink-0 text-[11px] font-bold uppercase text-teal-700">État</span>
                    <span class="truncate text-sm font-medium text-teal-900/75">{{ $condition }}</span>
                </p>
            </div>
        </article>
    </a>

    @if ($canEdit)
        <a href="{{ route('listings.edit', ['listing' => $slug]) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-4 py-2.5 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">
            Modifier
        </a>
    @endif
</div>