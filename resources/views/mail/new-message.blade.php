{{-- resources/views/mail/new-message.blade.php --}}
<x-mail::message>
# Bonjour {{ $newMessage->listing->user->name }},

**{{ $newMessage->user->name }}** vous a écrit à propos de votre annonce
« {{ $newMessage->listing->title }} » :

<x-mail::panel>
{{ $newMessage->message }}
</x-mail::panel>

<x-mail::button :url="route('annonce', $newMessage->listing)">
Voir l'annonce
</x-mail::button>

À bientôt,<br>
{{ config('app.name') }}
</x-mail::message>
