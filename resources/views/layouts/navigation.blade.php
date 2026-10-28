<nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- LOGO --}}
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="OportunidadJoven"
                    class="h-12 w-auto"
                >
            </a>

            {{-- PARTE DERECHA --}}
            <div class="flex items-center gap-3">

                {{-- NOTIFICACIONES --}}
                <button
                    type="button"
                    class="relative p-2 text-gray-600 hover:text-gray-900"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032
                            2.032 0 0118 14.158V11a6 6 0
                            00-12 0v3.159c0 .538-.214 1.055-.595
                            1.436L4 17h5m6 0v1a3 3 0
                            11-6 0v-1m6 0H9"
                        />
                    </svg>

                    <span
                        class="absolute top-1 right-1 h-2 w-2
                        bg-red-500 rounded-full"
                    ></span>
                </button>


                {{-- USUARIO --}}
                <div class="relative">

                    {{-- BOTÓN DEL USUARIO --}}
                    <button
                        type="button"
                        onclick="document.getElementById('user-menu').classList.toggle('hidden')"
                        class="flex items-center gap-2 px-3 py-2
                        border border-gray-300 rounded-md
                        text-sm text-gray-700 hover:bg-gray-50"
                    >

                        {{-- ICONO USUARIO --}}
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5.121 17.804A9 9 0
                                0112 15c2.485 0 4.735.999
                                6.364 2.636M15 10a3 3 0
                                11-6 0 3 3 0 016 0z"
                            />
                        </svg>

                        {{-- NOMBRE DEL USUARIO --}}
                        <span class="hidden sm:inline">
                            {{ Auth::user()->name }}
                        </span>

                        {{-- FLECHA --}}
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>

                    </button>


                    {{-- MENÚ DESPLEGABLE --}}
                    <div
                        id="user-menu"
                        class="hidden absolute right-0 mt-2 w-48
                        bg-white border border-gray-200
                        rounded-md shadow-lg z-50"
                    >

                        {{-- PERFIL --}}
                        <a
                            href="{{ route('profile.edit') }}"
                            class="block px-4 py-3 text-sm
                            text-gray-700 hover:bg-gray-50"
                        >
                            Mi Perfil
                        </a>

                    </div>

                </div>


                {{-- CERRAR SESIÓN --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium
                        text-white rounded-md transition"
                        style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%);"
                    >
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </div>
    </div>


    {{-- MENU --}}
    <div class="border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-1 overflow-x-auto">

                {{-- INICIO --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 px-4 py-3
                    border-b-2 border-[#05647a]
                    text-[#05647a]
                    whitespace-nowrap text-sm"
                >
                    Inicio
                </a>


                {{-- EMPLEOS --}}
                <a
                    href="#"
                    class="flex items-center gap-2 px-4 py-3
                    border-b-2 border-transparent
                    text-[#869684]
                    hover:text-[#05647a]
                    whitespace-nowrap text-sm"
                >
                    Empleos
                </a>


                {{-- PASANTÍAS --}}
                <a
                    href="#"
                    class="flex items-center gap-2 px-4 py-3
                    border-b-2 border-transparent
                    text-[#869684]
                    hover:text-[#05647a]
                    whitespace-nowrap text-sm"
                >
                    Pasantías
                </a>


                {{-- CURSOS --}}
                <a
                    href="#"
                    class="flex items-center gap-2 px-4 py-3
                    border-b-2 border-transparent
                    text-[#869684]
                    hover:text-[#05647a]
                    whitespace-nowrap text-sm"
                >
                    Cursos
                </a>


                {{-- FORO --}}
                <a
                    href="#"
                    class="flex items-center gap-2 px-4 py-3
                    border-b-2 border-transparent
                    text-[#869684]
                    hover:text-[#05647a]
                    whitespace-nowrap text-sm"
                >
                    Foro
                </a>

            </div>
        </div>
    </div>

</nav>