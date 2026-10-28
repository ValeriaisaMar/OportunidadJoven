<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Oportunidad Joven</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">

    {{-- ================================
        NAVBAR
    ================================= --}}
    <header class="border-b border-gray-200 bg-white">
        <div class="oj-container">

            <div class="flex h-20 items-center justify-between">

                {{-- Logo --}}
               <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Oportunidad Joven"
                    class="h-12 w-auto"
                >
            </a>


                {{-- Menú --}}
                <nav class="hidden items-center gap-8 md:flex">

                    <a href="{{ url('/') }}"
                       class="font-medium text-[#10375d] transition hover:text-[#05647a]">
                        Inicio
                    </a>

                    <a href="{{ route('empleos') }}"
                       class="font-medium text-gray-600 transition hover:text-[#05647a]">
                        Empleos
                    </a>

                    <a href="{{ route('pasantias') }}"
                       class="font-medium text-gray-600 transition hover:text-[#05647a]">
                        Pasantías
                    </a>

                    <a href="{{ route('cursos') }}"
                       class="font-medium text-gray-600 transition hover:text-[#05647a]">
                        Cursos
                    </a>

                    <a href="{{ route('foro') }}"
                       class="font-medium text-gray-600 transition hover:text-[#05647a]">
                        Foro
                    </a>

                </nav>


                {{-- Acciones --}}
                <div class="flex items-center gap-3">

                    <a href="{{ route('login') }}"
                       class="hidden rounded-lg px-4 py-2 font-semibold text-[#10375d] transition hover:bg-gray-100 sm:block">
                        Ingresar
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-lg bg-[#10375d] px-5 py-2.5 font-semibold text-white transition hover:bg-[#05647a]">
                        Registrarse
                    </a>

                </div>

            </div>

        </div>
    </header>


    {{-- ================================
        HERO
    ================================= --}}
    <section class="oj-hero">

        <div class="oj-container">

            <div class="grid min-h-[560px] items-center gap-12 py-16 lg:grid-cols-2">

                {{-- Texto --}}
                <div>



                    <h2 class="max-w-2xl text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                        Comienza tu carrera
                        <span class="text-[#6db8bb]">
                            profesional hoy
                        </span>
                    </h2>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-white/85">
                        Encuentra oportunidades laborales, pasantías,
                        cursos y recursos diseñados para ayudarte a
                        desarrollar tu futuro profesional.
                    </p>


                    {{-- Buscador --}}
                    <form class="mt-8 flex max-w-2xl flex-col gap-3 rounded-xl bg-white p-3 shadow-xl sm:flex-row">

                        <div class="flex flex-1 items-center gap-3 px-3">

                            <svg
                                class="h-5 w-5 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />

                            </svg>

                            <input
                                type="text"
                                placeholder="¿Qué estás buscando?"
                                class="w-full border-0 bg-transparent text-gray-800 outline-none focus:ring-0"
                            >

                        </div>

                        <button
                            type="submit"
                            class="rounded-lg bg-[#10375d] px-7 py-3 font-semibold text-white transition hover:bg-[#05647a]">
                            Buscar
                        </button>

                    </form>


                    {{-- Estadísticas --}}
                    <div class="mt-10 grid max-w-xl grid-cols-3 gap-6">

                        <div>
                            <p class="text-3xl font-bold text-white">
                                1,247
                            </p>

                            <p class="mt-1 text-sm text-white/70">
                                Empleos
                            </p>
                        </div>

                        <div>
                            <p class="text-3xl font-bold text-white">
                                356
                            </p>

                            <p class="mt-1 text-sm text-white/70">
                                Pasantías
                            </p>
                        </div>

                        <div>
                            <p class="text-3xl font-bold text-white">
                                89
                            </p>

                            <p class="mt-1 text-sm text-white/70">
                                Cursos
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Imagen / ilustración --}}
{{-- Imagen / ilustración --}}
<div class="hidden lg:flex lg:justify-end">

    <div class="relative w-full max-w-lg">

        <div class="absolute -right-5 -top-5 h-24 w-24 rounded-full bg-[#6db8bb]/30 blur-2xl"></div>

        <div class="absolute -bottom-5 -left-5 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>

        <div class="relative overflow-hidden rounded-3xl shadow-2xl">

            <img
                src="{{ asset('images/image1.png') }}"
                alt="Oportunidad Joven"
                class="h-[450px] w-full object-cover"
            >

        </div>

    </div>

</div>

  <div class="mt-6 text-center text-white">

            <p class="text-3xl font-bold alin">
                Tu futuro comienza aquí
            </p>

            <p class="mt-3 text-lg text-white/80">
                Encuentra nuevas oportunidades
            </p>

        </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


{{-- ================================
    ACCESOS RÁPIDOS
================================= --}}
<section class="oj-section py-20">

    <div class="oj-container">

        <div class="mx-auto max-w-2xl text-center">

            <p class="font-semibold text-[#05647a]">
                TODO EN UN SOLO LUGAR
            </p>

            <h2 class="mt-2 text-3xl font-bold text-[#10375d] sm:text-4xl">
                Construye tu futuro
            </h2>

            <p class="mt-4 text-gray-600">
                Explora las herramientas y oportunidades que tenemos
                para ayudarte a crecer profesionalmente.
            </p>

        </div>


        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Empleos --}}
            <a
                href="{{ route('empleos') }}"
                class="oj-card group p-6 transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#10375d]/10 text-2xl">
                    💼
                </div>

                <h3 class="mt-5 text-xl font-bold text-[#10375d]">
                    Empleos
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Encuentra ofertas laborales que se adapten
                    a tu perfil profesional.
                </p>

                <span class="mt-5 inline-block font-semibold text-[#05647a]">
                    Explorar →
                </span>

            </a>


            {{-- Pasantías --}}
            <a
                href="{{ route('pasantias') }}"
                class="oj-card group p-6 transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#6db8bb]/20 text-2xl">
                    🎯
                </div>

                <h3 class="mt-5 text-xl font-bold text-[#10375d]">
                    Pasantías
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Obtén experiencia y desarrolla tus habilidades
                    en organizaciones.
                </p>

                <span class="mt-5 inline-block font-semibold text-[#05647a]">
                    Ver pasantías →
                </span>

            </a>


            {{-- Cursos --}}
            <a
                href="{{ route('cursos') }}"
                class="oj-card group p-6 transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#869684]/15 text-2xl">
                    📚
                </div>

                <h3 class="mt-5 text-xl font-bold text-[#10375d]">
                    Cursos
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Aprende nuevas habilidades con cursos
                    pensados para jóvenes.
                </p>

                <span class="mt-5 inline-block font-semibold text-[#05647a]">
                    Ver cursos →
                </span>

            </a>


            {{-- Foro --}}
            <a
                href="{{ route('foro') }}"
                class="oj-card group p-6 transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#05647a]/10 text-2xl">
                    💬
                </div>

                <h3 class="mt-5 text-xl font-bold text-[#10375d]">
                    Comunidad
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Comparte experiencias, preguntas y consejos
                    con otros jóvenes.
                </p>

                <span class="mt-5 inline-block font-semibold text-[#05647a]">
                    Ir al foro →
                </span>

            </a>

        </div>

    </div>

</section>




    {{-- ================================
        CTA
    ================================= --}}
    <section class="bg-[#10375d] py-20">

        <div class="oj-container">

            <div class="rounded-3xl bg-gradient-to-r from-[#05647a] to-[#10375d] px-8 py-14 text-center shadow-xl sm:px-14">

                <h2 class="text-3xl font-bold text-white sm:text-4xl">
                    ¿Listo para comenzar?
                </h2>

                <p class="mx-auto mt-4 max-w-2xl text-white/80">
                    Crea tu cuenta y comienza a explorar oportunidades
                    para construir tu futuro profesional.
                </p>

                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">

                    <a
                        href="{{ route('register') }}"
                        class="rounded-lg bg-white px-7 py-3 font-semibold text-[#10375d] transition hover:bg-gray-100">
                        Crear mi cuenta
                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="rounded-lg border border-white/30 px-7 py-3 font-semibold text-white transition hover:bg-white/10">
                        Ya tengo una cuenta
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- ================================
        FOOTER
    ================================= --}}
    <footer class="bg-[#0b2945] py-10 text-white">

        <div class="oj-container">

            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">

                <div>

                    <h3 class="text-xl font-bold">
                        Oportunidad Joven
                    </h3>

                    <p class="mt-2 text-sm text-white/60">
                        Conectando jóvenes con oportunidades.
                    </p>

                </div>

                <p class="text-sm text-white/50">
                    © {{ date('Y') }} Oportunidad Joven. Todos los derechos reservados.
                </p>

            </div>

        </div>

    </footer>

</body>

</html>

