<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DreamBox</title>
        
        @vite('resources/css/front.css')
    </head>
    <body>
        <div id="front"></div>
        
        @vite('resources/js/front.js')
    </body>
</html>