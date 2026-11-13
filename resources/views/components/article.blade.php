@props(['id', 'title', 'description', 'condition', 'price'])
<a href="{{ route('annonce', ['listing' => $id]) }}">
<article class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
    <p  class="mb-3 inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-teal-900">
        Article #{{ $id }}
    </p>

    <h2 class="text-2xl font-extrabold tracking-tight text-teal-900">
        {{ $title }}
    </h2>

    <p class="mt-3 text-xl font-bold text-teal-900">
        {{ number_format((float) $price, 2, ',', ' ') }} €
    </p>

    <p class="mt-3 leading-7 text-teal-900/75">
        {{ $description }}
    </p>
    <p class="mt-3 leading-7 text-teal-900/75">
        Condition: {{ $condition }}
    </p>    

</article>
</a>