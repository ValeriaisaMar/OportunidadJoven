{{-- Encabezado y pestañas, igual que el diseño de Figma (YouthPortalHeader + YouthPortalNavigation) --}}
@php
    $pestanasNav = [
        ['ruta' => 'home', 'activo' => 'home', 'titulo' => 'Inicio', 'icono' => 'home'],
        ['ruta' => 'empleos', 'activo' => 'empleos', 'titulo' => 'Empleos', 'icono' => 'briefcase'],
        ['ruta' => 'pasantias', 'activo' => 'pasantias', 'titulo' => 'Pasantías', 'icono' => 'graduation-cap'],
        ['ruta' => 'cursos', 'activo' => 'cursos', 'titulo' => 'Cursos', 'icono' => 'book-open'],
        ['ruta' => 'foro', 'activo' => 'foro*', 'titulo' => 'Foro', 'icono' => 'message-square'],
    ];
@endphp

{{-- Fila 1: logo y botones --}}
<header class="sticky top-0 z-50 border-b border-gray-200 bg-white shadow-sm">
    <div class="oj-container">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="OportunidadJoven" class="h-12 object-contain">
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="oj-btn-ghost oj-btn-sm relative" title="Mi panel">
                        <x-icon name="bell" class="h-5 w-5" />
                    </a>

                    <a href="{{ route('profile.edit') }}" class="oj-btn-outline oj-btn-sm">
                        <x-icon name="user" class="h-4 w-4" />
                        <span class="hidden sm:inline">Mi Perfil</span>
                    </a>

                    {{-- Menú de la cuenta --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button" class="oj-btn-gradient oj-btn-sm">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-white/20 text-[10px]">
                                    {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden max-w-[10rem] truncate sm:inline">{{ Str::before(Auth::user()->name, ' ') }}</span>
                                <x-icon name="chevron-down" class="h-4 w-4" />
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="border-b border-gray-100 px-4 py-2">
                                <p class="truncate text-sm text-oj-primary">{{ Auth::user()->name }}</p>
                                <p class="truncate text-xs text-oj-muted">{{ Auth::user()->email }}</p>
                            </div>
                            <x-dropdown-link :href="route('dashboard')">Mi panel</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Mi perfil</x-dropdown-link>
                            @if (Auth::user()->esAdmin())
                                <x-dropdown-link :href="route('admin.empleos.index')">Administrar</x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('register') }}" class="oj-btn-outline oj-btn-sm">
                        <x-icon name="user" class="h-4 w-4" />
                        <span class="hidden sm:inline">Registrarme</span>
                    </a>

                    <a href="{{ route('login') }}" class="oj-btn-gradient oj-btn-sm">
                        <x-icon name="log-in" class="h-4 w-4" />
                        <span class="hidden sm:inline">Ingresar</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- Fila 2: pestañas --}}
<nav class="border-b border-gray-200 bg-white shadow-sm">
    <div class="oj-container">
        <div class="flex gap-1 overflow-x-auto">
            @foreach ($pestanasNav as $pestana)
                @php $activa = request()->routeIs($pestana['activo']); @endphp
                <a href="{{ route($pestana['ruta']) }}"
                   class="flex items-center gap-2 whitespace-nowrap border-b-2 px-4 py-3 transition-colors
                          {{ $activa ? 'border-oj-accent text-oj-accent' : 'border-transparent text-oj-muted hover:text-oj-accent' }}">
                    <x-icon :name="$pestana['icono']" class="h-4 w-4" />
                    <span class="text-sm">{{ $pestana['titulo'] }}</span>
                </a>
            @endforeach

            @auth
                @if (Auth::user()->esAdmin())
                    <a href="{{ route('admin.empleos.index') }}"
                       class="flex items-center gap-2 whitespace-nowrap border-b-2 px-4 py-3 transition-colors
                              {{ request()->routeIs('admin.*') ? 'border-oj-accent text-oj-accent' : 'border-transparent text-oj-muted hover:text-oj-accent' }}">
                        <x-icon name="settings" class="h-4 w-4" />
                        <span class="text-sm">Administrar</span>
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>
