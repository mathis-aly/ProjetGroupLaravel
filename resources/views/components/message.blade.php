@props(['message', 'author' => 'Acheteur', 'isOwn' => false])

<div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}">
    <article class="max-w-[85%] sm:max-w-[75%]">
        <div class="mb-1 flex items-center gap-2 px-1 {{ $isOwn ? 'justify-end' : '' }}">
            <span class="text-[11px] font-bold {{ $isOwn ? 'text-teal-800' : 'text-teal-950' }}">
                {{ $isOwn ? 'Vous' : $author }}
            </span>
            @if ($message->created_at)
                <time datetime="{{ $message->created_at->toIso8601String() }}" class="text-[11px] text-teal-900/50">
                    {{ $message->created_at->format('d/m/Y à H:i') }}
                </time>
            @endif
        </div>

        <p class="rounded-2xl px-4 py-3 text-sm leading-relaxed shadow-sm {{ $isOwn ? 'rounded-br-none bg-teal-900 text-white' : 'rounded-bl-none border border-teal-900/10 bg-white text-teal-950' }}">
            {{ $message->message }}
        </p>
    </article>
</div>