<x-app-layout>
    @php
        $accesos = [
            ['ruta' => 'empleos', 'color' => '#10375d', 'fondo' => 'rgba(16, 55, 93, 0.1)', 'icono' => 'briefcase',
             'titulo' => 'Empleos sin experiencia', 'texto' => 'Encuentra trabajos ideales para comenzar tu carrera', 'boton' => 'Ver empleos'],
            ['ruta' => 'pasantias', 'color' => '#05647a', 'fondo' => 'rgba(5, 100, 122, 0.1)', 'icono' => 'graduation-cap',
             'titulo' => 'Pasantías y Trainee', 'texto' => 'Aprende mientras trabajas con las mejores empresas', 'boton' => 'Ver pasantías'],
            ['ruta' => 'cursos', 'color' => '#6db8bb', 'fondo' => 'rgba(109, 184, 187, 0.1)', 'icono' => 'book-open',
             'titulo' => 'Cursos Gratuitos', 'texto' => 'Capacítate con cursos certificados de calidad', 'boton' => 'Ver cursos'],
            ['ruta' => 'foro', 'color' => '#869684', 'fondo' => 'rgba(134, 150, 132, 0.1)', 'icono' => 'message-square',
             'titulo' => 'Foro Comunidad', 'texto' => 'Comparte experiencias y consejos con otros jóvenes', 'boton' => 'Ver foro'],
        ];
    @endphp

    <div class="min-h-screen" style="background: linear-gradient(180deg, #e0e2d5 0%, #ffffff 100%);">

        {{-- Hero --}}
        <section class="text-white" style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%);">
            <div class="oj-container py-16 sm:py-20">
                <div class="grid items-center gap-12 md:grid-cols-2">
                    <div>
                        <h1 class="mb-6 text-4xl sm:text-5xl">Comienza tu carrera profesional hoy</h1>
                        <p class="mb-8 text-xl text-oj-secondary">
                            Encuentra empleos, pasantías y cursos diseñados para jóvenes sin experiencia.
                            Tu oportunidad está aquí.
                        </p>

                        {{-- Buscador: busca en los empleos --}}
                        <form method="GET" action="{{ route('empleos') }}" class="flex gap-2 rounded-lg bg-white p-2 shadow-lg">
                            <input type="text" name="q" placeholder="¿Qué estás buscando?"
                                   class="h-9 w-full rounded-md border-0 bg-transparent px-3 text-sm text-gray-900 placeholder:text-gray-500 focus:ring-0">
                            <button type="submit" class="oj-btn bg-oj-accent text-white hover:opacity-90">
                                <x-icon name="search" class="h-4 w-4" />
                                Buscar
                            </button>
                        </form>

                        {{-- Cifras reales --}}
                        <div class="mt-8 grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="mb-1 text-3xl">{{ $stats['empleos'] }}</div>
                                <div class="text-sm text-oj-secondary">Empleos</div>
                            </div>
                            <div class="text-center">
                                <div class="mb-1 text-3xl">{{ $stats['pasantias'] }}</div>
                                <div class="text-sm text-oj-secondary">Pasantías</div>
                            </div>
                            <div class="text-center">
                                <div class="mb-1 text-3xl">{{ $stats['cursos'] }}</div>
                                <div class="text-sm text-oj-secondary">Cursos</div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block">
                        <img src="{{ asset('images/ofertas/oferta-1.jpg') }}" alt="Jóvenes profesionales"
                             class="h-96 w-full rounded-lg object-cover shadow-2xl">
                    </div>
                </div>
            </div>
        </section>

        {{-- Accesos rápidos --}}
        <section class="oj-container -mt-12">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($accesos as $acceso)
                    <a href="{{ route($acceso['ruta']) }}"
                       class="oj-card group flex flex-col gap-6 border-t-4 transition-shadow hover:shadow-lg"
                       style="border-top-color: {{ $acceso['color'] }};">
                        <div class="px-6 pt-6">
                            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-lg" style="background-color: {{ $acceso['fondo'] }};">
                                <x-icon :name="$acceso['icono']" class="h-6 w-6" style="color: {{ $acceso['color'] }};" />
                            </div>
                            <h4 class="leading-none">{{ $acceso['titulo'] }}</h4>
                            <p class="mt-1.5 text-oj-muted">{{ $acceso['texto'] }}</p>
                        </div>
                        <div class="mt-auto px-6 pb-6">
                            <span class="oj-btn-ghost w-full justify-between">
                                {{ $acceso['boton'] }}
                                <x-icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Empleos destacados --}}
        <section class="oj-container py-16">
            <div class="mb-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="mb-2 text-3xl text-gray-900">Empleos destacados</h2>
                    <p class="text-gray-600">Oportunidades recientes para ti</p>
                </div>
                <a href="{{ route('empleos') }}" class="oj-btn-outline">Ver todos</a>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($empleosDestacados as $empleo)
                    <div class="oj-card flex flex-col transition-shadow hover:shadow-lg">
                        <img src="{{ $empleo->foto_url }}" alt="{{ $empleo->titulo }}" class="h-40 w-full rounded-t-xl object-cover">
                        <div class="px-6 pt-6">
                            <div class="mb-2 flex items-start justify-between gap-2">
                                <span class="oj-badge bg-blue-100 text-blue-700">{{ $empleo->experiencia }}</span>
                                <span class="text-xs text-gray-500">{{ $empleo->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="text-lg leading-tight">{{ $empleo->titulo }}</h4>
                            <p class="mt-1.5 text-oj-muted">{{ $empleo->empresa }}</p>
                        </div>
                        <div class="mt-auto px-6 pb-6 pt-6">
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <x-icon name="map-pin" class="h-4 w-4" />
                                    {{ $empleo->ubicacion }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-icon name="trending-up" class="h-4 w-4" />
                                    {{ $empleo->salario ?? 'A convenir' }}
                                </div>
                            </div>
                            <a href="{{ route('empleos', ['q' => $empleo->titulo]) }}" class="oj-btn-primary mt-4 w-full">Aplicar ahora</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Pronto publicaremos nuevas vacantes.</p>
                @endforelse
            </div>
        </section>

        {{-- Cursos disponibles --}}
        <section class="bg-gray-50 py-16">
            <div class="oj-container">
                <div class="mb-8 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="mb-2 text-3xl text-gray-900">Cursos disponibles</h2>
                        <p class="text-gray-600">Capacítate y mejora tu perfil profesional</p>
                    </div>
                    <a href="{{ route('cursos') }}" class="oj-btn-outline">Ver todos</a>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($cursosDestacados as $curso)
                        <div class="oj-card flex flex-col transition-shadow hover:shadow-lg">
                            <div class="px-6 pt-6">
                                <div class="mb-3 flex items-center justify-between gap-2">
                                    <span class="oj-badge bg-green-100 text-green-700">Gratuito</span>
                                    <span class="oj-badge-outline">
                                        {{ $curso->cupos !== null ? $curso->cupos . ' cupos' : ($curso->certificado ? 'Con certificado' : $curso->modalidad) }}
                                    </span>
                                </div>
                                <h4 class="text-lg leading-tight">{{ $curso->titulo }}</h4>
                                <p class="mt-1.5 text-oj-muted">{{ $curso->institucion }}</p>
                            </div>
                            <div class="mt-auto px-6 pb-6 pt-6">
                                <div class="mb-4 space-y-2 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <x-icon name="clock" class="h-4 w-4" />
                                        {{ $curso->duracion ?? 'Duración a consultar' }} • {{ $curso->modalidad }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <x-icon name="graduation-cap" class="h-4 w-4" />
                                        {{ $curso->fecha_inicio ? 'Inicia: ' . $curso->fecha_inicio->format('d/m/Y') : 'Inscripción abierta' }}
                                    </div>
                                </div>
                                <a href="{{ route('cursos', ['q' => $curso->titulo]) }}" class="oj-btn-outline w-full">Inscribirse</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Pronto publicaremos nuevos cursos.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Llamado a la acción --}}
        <section class="py-16 text-white" style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%);">
            <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                @guest
                    <h2 class="mb-4 text-3xl">¿Listo para comenzar?</h2>
                    <p class="mb-8 text-xl text-oj-secondary">
                        Crea tu perfil gratis y accede a oportunidades diseñadas para ti
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}" class="oj-btn oj-btn-lg bg-white text-oj-primary hover:opacity-90">Crear cuenta gratis</a>
                        <a href="{{ route('cursos') }}" class="oj-btn oj-btn-lg border border-white text-white hover:bg-white/10">Más información</a>
                    </div>
                @else
                    <h2 class="mb-4 text-3xl">¡Hola, {{ Str::before(Auth::user()->name, ' ') }}!</h2>
                    <p class="mb-8 text-xl text-oj-secondary">
                        Completa tu perfil para que las empresas conozcan lo que sabes hacer
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('dashboard') }}" class="oj-btn oj-btn-lg bg-white text-oj-primary hover:opacity-90">Ir a mi panel</a>
                        <a href="{{ route('profile.edit') }}" class="oj-btn oj-btn-lg border border-white text-white hover:bg-white/10">Completar mi perfil</a>
                    </div>
                @endguest
            </div>
        </section>
    </div>
</x-app-layout>
