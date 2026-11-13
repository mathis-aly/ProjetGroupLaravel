@props(['id', 'title', 'description'])
<a href="{{ route('annonce', ['id' => $id]) }}">
<article class="rounded-2xl border border-teal-900/10 bg-white p-6 shadow-lg shadow-teal-900/5">
    <p  class="mb-3 inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-teal-900">
        Article #{{ $id }}
    </p>

    <h2 class="text-2xl font-extrabold tracking-tight text-teal-900">
        {{ $title }}
    </h2>

    <p class="mt-3 leading-7 text-teal-900/75">
        {{ $description }}
    </p>
</article>
</a>