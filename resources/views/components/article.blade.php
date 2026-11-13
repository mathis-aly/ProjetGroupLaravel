@props(['slug', 'title', 'description','condition'])
<a href="{{ route('annonce', ['listing' => $slug]) }}">
<article class="flex h-[22rem] flex-col overflow-hidden rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
    <p  class="mb-3 inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-teal-900">
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
    <p title="{{ $condition }}" class="mt-auto line-clamp-1 min-h-7 leading-7 text-teal-900/75">
        Condition: {{ $condition }}
    </p>    

</article>
</a>