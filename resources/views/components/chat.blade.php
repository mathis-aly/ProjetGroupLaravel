@props([
    'messages' => [],
    'contactName' => 'Contact',
    'title' => 'Conversation',
    'price' => null,
    'preview' => 'Aucun message pour le moment',
    'listing' => null,
    'open' => false,
])

<details class="group overflow-hidden rounded-2xl border border-teal-900/10 bg-white shadow-lg shadow-teal-900/5" @if ($open) open @endif>
    <summary class="flex cursor-pointer list-none items-center gap-3 px-5 py-4 transition hover:bg-amber-50/70 sm:px-6">
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-teal-900 text-sm font-extrabold text-amber-400">
            {{ strtoupper(substr($contactName, 0, 1)) }}
        </span>
        <span class="min-w-0 flex-1">
            <span class="flex flex-wrap items-center justify-between gap-x-3 gap-y-1">
                <span class="truncate text-sm font-extrabold text-teal-950">{{ $contactName }}</span>
                <span class="text-[11px] font-semibold text-teal-900/50">
                    {{ count($messages) }} message{{ count($messages) > 1 ? 's' : '' }}
                </span>
            </span>
            <span class="mt-1 block truncate text-xs text-teal-900/65">
                {{ $preview }}
            </span>
        </span>
        <span class="ml-1 text-teal-700 transition group-open:rotate-180" aria-hidden="true">⌄</span>
    </summary>

    <div class="border-t border-teal-900/10">
        <header class="flex flex-wrap items-center justify-between gap-2 bg-white px-5 py-3 sm:px-6">
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-teal-700">{{ $contactName }} · Conversation</p>
                <h3 class="truncate text-sm font-extrabold text-teal-950">{{ $title }}</h3>
            </div>
            @if ($price !== null)
                <span class="rounded-lg bg-amber-100 px-3 py-1 text-xs font-extrabold text-teal-950">
                    {{ number_format((float) $price, 2, ',', ' ') }} €
                </span>
            @endif
        </header>

        <div class="min-h-24 space-y-4 bg-amber-50/40 px-4 py-5 sm:px-6">
            @forelse ($messages as $chatMessage)
                <x-message
                    :message="$chatMessage"
                    :author="data_get($chatMessage, 'user.name', $contactName)"
                    :is-own="data_get($chatMessage, 'is_own', false)"
                />
            @empty
                <p class="text-sm text-teal-900/60">Aucun message dans cette conversation.</p>
            @endforelse
        </div>

        @if ($listing && (!auth()->check() || (int) auth()->id() !== (int) $listing->user_id))
            <div class="border-t border-teal-900/10 bg-white p-4 sm:px-6">
                @if (session('status'))
                    <p role="status" class="mb-3 rounded-lg bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-800">
                        {{ session('status') }}
                    </p>
                @endif

                @auth
                    <form method="POST" action="{{ route('chat.store', $listing) }}" class="space-y-3">
                        @csrf
                        <label for="chat-message" class="block text-sm font-bold text-teal-950">Votre message</label>
                        <textarea
                            id="chat-message"
                            name="message"
                            rows="3"
                            maxlength="5000"
                            required
                            placeholder="Écrivez au vendeur à propos de cette annonce..."
                            class="block w-full resize-y rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 placeholder-teal-900/40 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-sm font-semibold text-red-700">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-teal-900/70">
                        <a href="{{ route('login') }}" class="font-bold text-teal-800 underline underline-offset-2">Connectez-vous</a>
                        pour envoyer un message au vendeur.
                    </p>
                @endauth
            </div>
        @endif
    </div>
</details>