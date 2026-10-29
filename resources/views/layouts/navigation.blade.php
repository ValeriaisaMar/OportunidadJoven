<nav x-data="{ open: false }" class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                {{-- Logo --}}
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{-- Enlaces del centro, visibles para todos --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link :href="route('empleos')" :active="request()->routeIs('empleos')">
                        {{ __('Empleos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pasantias')" :active="request()->routeIs('pasantias')">
                        {{ __('Pasantías') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cursos')" :active="request()->routeIs('cursos')">
                        {{ __('Cursos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('foro')" :active="request()->routeIs('foro')">
                        {{ __('Foro') }}
                    </x-nav-link>

                    {{-- Solo para administradores --}}
                    @auth
                        @if (auth()->user()->esAdmin())
                            <x-nav-link :href="route('admin.empleos.index')" :active="request()->routeIs('admin.*')">
                                {{ __('Administrar') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Lado derecho: cambia según si está logueado o no --}}
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                @auth
                    <div class="relative ms-3">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button type="button" class="flex items-center rounded-md border border-transparent px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    {{ Auth::user()->name }}
                                    <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('dashboard')">{{ __('Mi panel') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Mi perfil') }}</x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-[#10375d] hover:underline">
                            {{ __('Ingresar') }}
                        </a>
                        <a href="{{ route('register') }}" class="rounded-md bg-[#10375d] px-4 py-2 text-sm font-medium text-white hover:bg-[#10375d]/90">
                            {{ __('Registrarme') }}
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Botón de hamburguesa para celular --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú para celular --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">{{ __('Inicio') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('empleos')" :active="request()->routeIs('empleos')">{{ __('Empleos') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pasantias')" :active="request()->routeIs('pasantias')">{{ __('Pasantías') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cursos')" :active="request()->routeIs('cursos')">{{ __('Cursos') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('foro')" :active="request()->routeIs('foro')">{{ __('Foro') }}</x-responsive-nav-link>

            @auth
                @if (auth()->user()->esAdmin())
                    <x-responsive-nav-link :href="route('admin.empleos.index')" :active="request()->routeIs('admin.*')">{{ __('Administrar') }}</x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <div class="border-t border-gray-200 pb-1 pt-4">
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')">{{ __('Mi panel') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Mi perfil') }}</x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="border-t border-gray-200 pb-1 pt-4">
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">{{ __('Ingresar') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">{{ __('Registrarme') }}</x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>