<x-layouts.public :title="$article['title'] . ' | UberBite(Coin)'">
    <section class="mx-auto flex min-h-[calc(100vh-10rem)] w-full max-w-7xl flex-col px-5 py-8 sm:px-8 sm:py-12" aria-labelledby="article-title">
        <a href="{{ url('/annonces') }}" class="group mb-8 inline-flex w-fit items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold text-teal-900/70 transition hover:bg-teal-900/5 hover:text-teal-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-900">
            <svg class="h-4 w-4 transition group-hover:-translate-x-1" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M16 10H4m0 0 5-5m-5 5 5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Toutes les annonces
        </a>

        <article class="grid flex-1 overflow-hidden rounded-3xl bg-white shadow-xl shadow-teal-950/10 md:grid-cols-[1.1fr_.9fr]">
            <div class="flex flex-col justify-center bg-teal-900 px-7 py-12 text-white sm:px-12 sm:py-16 lg:px-16">
                <p class="mb-8 flex items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] text-amber-100">
                    <span class="h-px w-8 bg-amber-400" aria-hidden="true"></span>
                    Article #{{ $article['id'] }}
                </p>

                <h1 id="article-title" class="break-words text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                    {{ $article['title'] }}
                </h1>

                <div class="mt-8 h-1 w-14 rounded-full bg-amber-400" aria-hidden="true"></div>
                <p class="mt-6 text-sm font-semibold text-amber-100/70">Le goût du quartier.</p>
            </div>

            <div class="flex flex-col justify-center px-7 py-12 sm:px-12 sm:py-16 lg:px-16">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">À propos</p>
                <p class="mt-6 text-lg leading-8 text-teal-950/75 sm:text-xl sm:leading-9">
                    {{ $article['description'] }}
                </p>
            </div>
        </article>
    </section>
</x-layouts.public>
