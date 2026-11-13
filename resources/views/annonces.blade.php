<x-layouts.public title="Uberbite(Coin)">

    <div class="bg-amber-100 text-white">
        <div class="relative mx-auto mt-8 w-[calc(100%-2rem)] max-w-7xl overflow-hidden rounded-3xl bg-teal-900 px-6 py-12 text-center shadow-xl shadow-teal-900/10 sm:mt-12 sm:px-10 sm:py-16">

            <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl">
                Annonces
            </h1>

            <span class="absolute -right-10 -top-14 h-40 w-40 rounded-full border border-white/10" aria-hidden="true"></span>
            <span class="absolute -bottom-24 -left-8 h-48 w-48 rounded-full border border-amber-400/20" aria-hidden="true"></span>
        </div>
        <section class="mx-auto min-h-[65vh] max-w-7xl px-6 py-10" aria-labelledby="annonces-title">
            <div class="mb-8">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-teal-700">À découvrir près de chez toi</p>
                <h2 id="annonces-title" class="mt-2 text-3xl font-extrabold tracking-tight text-teal-900 sm:text-4xl">
                    Les annonces du moment
                </h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-article
                        :id="$article['id']"
                        :title="$article['title']"
                        :description="$article['description']"
                    />
                @endforeach
            </div>
        </section>


    </div>
    
</x-layouts.public>
 