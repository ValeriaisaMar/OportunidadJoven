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

<body class="bg-white font-sans text-oj-primary antialiased">

    <div class="flex min-h-screen flex-col">

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
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Pie de página (igual que Figma) -->
        <footer class="bg-gray-900 py-12 text-gray-300">
            <div class="oj-container">
                <div class="grid gap-8 md:grid-cols-4">
                    <div>
                        <img src="{{ asset('images/logo.png') }}" alt="OportunidadJoven" class="mb-4 h-10 object-contain brightness-200">
                        <p class="text-sm">Conectando jóvenes con oportunidades laborales y educativas.</p>
                    </div>
                    <div>
                        <h4 class="mb-3 text-sm text-white">Enlaces rápidos</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('empleos') }}" class="hover:text-white">Empleos</a></li>
                            <li><a href="{{ route('pasantias') }}" class="hover:text-white">Pasantías</a></li>
                            <li><a href="{{ route('cursos') }}" class="hover:text-white">Cursos</a></li>
                            <li><a href="{{ route('foro') }}" class="hover:text-white">Foro</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-3 text-sm text-white">Tu cuenta</h4>
                        <ul class="space-y-2 text-sm">
                            @auth
                                <li><a href="{{ route('dashboard') }}" class="hover:text-white">Mi panel</a></li>
                                <li><a href="{{ route('profile.edit') }}" class="hover:text-white">Mi perfil</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="hover:text-white">Ingresar</a></li>
                                <li><a href="{{ route('register') }}" class="hover:text-white">Crear cuenta</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-3 text-sm text-white">Sobre las ofertas</h4>
                        <p class="text-sm">
                            Las vacantes y cursos enlazan a su publicación original. La postulación o
                            inscripción se hace en la página de cada convocatoria.
                        </p>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-800 pt-8 text-center text-sm">
                    <p>&copy; {{ now()->year }} OportunidadJoven. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>

    </div>

</body>

</html>
