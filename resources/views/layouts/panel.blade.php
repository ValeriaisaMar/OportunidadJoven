<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Mi espacio | Oportunidad Joven' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#10375d]">

    <div class="flex min-h-screen">

        {{-- ===== Menú lateral ===== --}}
        <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 border-r border-gray-200 px-5 py-6">

            <a href="{{ route('home') }}" class="flex items-center gap-2 mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Oportunidad Joven" class="h-9 w-auto">
            </a>

            <p class="text-xs font-medium text-gray-400 tracking-wide mb-3">TU ESPACIO</p>

            @php
                $panelNav = [
                    ['ruta' => 'dashboard', 'etiqueta' => 'Inicio', 'icono' => 'home'],
                    ['ruta' => 'empleos', 'etiqueta' => 'Empleos', 'icono' => 'briefcase'],
                    ['ruta' => 'pasantias', 'etiqueta' => 'Pasantías', 'icono' => 'graduation-cap'],
                    ['ruta' => 'cursos', 'etiqueta' => 'Cursos', 'icono' => 'book-open'],
                    ['ruta' => 'foro', 'etiqueta' => 'Comunidad', 'icono' => 'users'],
                ];
            @endphp

            <nav class="space-y-1 mb-auto">
                @foreach ($panelNav as $item)
                    @php $activo = request()->routeIs($item['ruta']); @endphp
                    <a href="{{ route($item['ruta']) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                              {{ $activo ? 'bg-[#10375d] text-white' : 'text-[#10375d]/70 hover:bg-gray-100' }}">
                        <x-icon name="{{ $item['icono'] }}" class="h-4 w-4" />
                        {{ $item['etiqueta'] }}
                        @if ($activo)
                            <span class="ml-auto h-1.5 w-1.5 rounded-full bg-white"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- Perfil completado --}}
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 mt-6">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-2">
                    <x-icon name="target" class="h-3.5 w-3.5" />
                    Perfil al 72%
                </div>
                <div class="h-1.5 w-full rounded-full bg-gray-200">
                    <div class="h-1.5 rounded-full bg-[#6db8bb]" style="width: 72%"></div>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-xs font-medium text-[#05647a] hover:underline mt-2 inline-block">
                    Completar perfil →
                </a>
            </div>

            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 mt-4 text-sm font-medium text-[#10375d]/70 hover:bg-gray-100 rounded-lg">
                <x-icon name="settings" class="h-4 w-4" />
                Configuración
            </a>
        </aside>

        {{-- ===== Contenido principal ===== --}}
        <div class="flex-1 min-w-0">

            {{-- Barra superior --}}
            <div class="flex items-center justify-between gap-4 border-b border-gray-200 px-6 py-4">
                <div class="relative w-full max-w-md">
                    <x-icon name="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                    <input type="text" placeholder="Buscar oportunidades, cursos o empresas"
                           class="w-full rounded-md border border-gray-200 pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6db8bb]">
                </div>

                <div class="flex items-center gap-4 shrink-0">
                    <button class="relative text-gray-500 hover:text-[#10375d]">
                        <x-icon name="bell" class="h-5 w-5" />
                        <span class="absolute -right-0.5 -top-0.5 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>

                    <div class="flex items-center gap-2">
                        <div class="h-9 w-9 rounded-full bg-[#10375d] text-white flex items-center justify-center text-sm font-semibold">
                            {{ collect(explode(' ', auth()->user()->name))->map(fn($p) => mb_substr($p, 0, 1))->take(2)->join('') }}
                        </div>
                        <div class="hidden sm:block leading-tight">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Buscando oportunidades</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-xs font-medium text-gray-400 hover:text-red-600">Salir</button>
                    </form>
                </div>
            </div>

            <main class="px-6 py-8">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>