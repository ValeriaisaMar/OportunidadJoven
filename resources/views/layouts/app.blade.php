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

<body class="bg-white text-gray-800">

    <div class="min-h-screen">

        <!-- Header reutilizable -->
        <header class="border-b border-gray-200 bg-white">
            <div class="oj-container">
                <div class="flex h-20 items-center justify-between">

                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Oportunidad Joven"
                            class="h-12 w-auto"
                        >
                    </a>

                    <!-- Volver al inicio -->
                    <a
                        href="{{ route('home') }}"
                        class="font-medium text-[#10375d] hover:text-[#05647a]"
                    >
                        ← Volver al inicio
                    </a>

                </div>
            </div>
        </header>

        <!-- Contenido de cada página -->
        <main>
            {{ $slot }}
        </main>

    </div>

</body>

</html>

