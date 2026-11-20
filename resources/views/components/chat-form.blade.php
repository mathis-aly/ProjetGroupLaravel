@props(['listing'])

<form method="POST" action="{{ route('chat.store', $listing) }}" class="rounded-2xl border border-teal-900/10 bg-white p-5 shadow-lg shadow-teal-900/5 sm:p-6">
    @csrf
    @if (session('status'))
        <p role="status" class="mb-4 rounded-lg bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </p>
    @endif
    <label for="chat-message-{{ $listing->id }}" class="block text-sm font-bold text-teal-950">
        Votre message au vendeur
    </label>
    <textarea
        id="chat-message-{{ $listing->id }}"
        name="message"
        rows="4"
        maxlength="2000"
        required
        placeholder="Bonjour, je suis intéressé par votre annonce..."
        class="mt-2 block w-full resize-y rounded-xl border border-teal-900/20 bg-white px-4 py-3 text-sm text-teal-950 placeholder-teal-900/40 shadow-sm focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-amber-400"
    >{{ old('message') }}</textarea>
    @error('message')
        <p class="mt-2 text-sm font-semibold text-red-700">{{ $message }}</p>
    @enderror
    <div class="mt-3 flex justify-end">
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-teal-950 shadow-sm transition hover:bg-amber-300">
            Envoyer le message
        </button>
    </div>
</form>
