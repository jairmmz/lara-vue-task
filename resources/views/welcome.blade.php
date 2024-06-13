<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <title>Laravel Task App</title>
    </head>
    <body class="h-full">
        <div id="app"></div>
        @vite('resources/js/app.ts')
        <!-- loading script with vite blade directive -->
    </body>
</html>
