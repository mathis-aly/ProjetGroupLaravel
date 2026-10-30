<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'UberBite(Coin)') }}</title>
    </head>
    
    <body>
        <x-card title="annonce" > 
            <p>liste des annonces</p>
            <xlisting-card :listing="$listing" class="mt-4" />
        </x-card>

    </body>
</html>
