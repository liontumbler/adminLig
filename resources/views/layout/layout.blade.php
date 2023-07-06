<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Edwin Velasquez Jimenez" />
        <meta name="copyright" content="Copyright AdminLig Edwin Velasquez Jimenez" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" href="img/adminLig.ico">

        <meta name="description" content="Descripcion de pagina. No superar los 155 caracteres." />
        <meta name="keywords" content="keyword 1, keyword 2, keyword 3"/>
        <meta name="revisit" content="2 days">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="canonical" href="{{ env('APP_URL') }}"/>

        <title>@yield('title')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @yield('content')
    </body>
</html>
