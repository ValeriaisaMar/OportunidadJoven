<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Oportunidad Joven') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800" x-data="{ open: false }">

    <div class="min-h-screen">

        @include('layouts.navigation')

        <!-- Encabezado propio de cada página (opcional) -->
        @isset($header)
            <header class="border-b border-gray-200 bg-white">
                <div class="oj-container py-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Contenido de cada página -->
        <main>
            {{ $slot }}
        </main>

    </div>

</body>

</html>