<x-app-layout>

    @php
        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

        $pestanas = ['todos' => 'Todos', 'proximos' => 'Próximos', 'guardados' => 'Guardados'];

        $degradado = 'oj-btn w-full bg-gradient-to-r from-green-600 to-blue-600 text-white hover:from-green-700 hover:to-blue-700';
    @endphp

    <div class="oj-page">
        <div class="oj-container py-8">

            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="oj-title">Cursos Gratuitos Disponibles</h1>
                <p class="text-gray-600">Capacítate con cursos certificados de instituciones reconocidas</p>
            </div>

            {{-- Aviso --}}
            <div class="mb-6 rounded-lg border border-green-200 bg-gradient-to-r from-green-50 to-blue-50 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-green-100">
                        <x-icon name="book-open" class="h-6 w-6 text-green-600" />
                    </div>
                    <div>
                        <h3 class="mb-2 text-lg text-gray-900">Todos los cursos son gratuitos y certificados</h3>
                        <p class="text-sm text-gray-600">
                            Estos cursos son ofrecidos por instituciones reconocidas. Al finalizar recibirás un
                            certificado o insignia que podrás agregar a tu CV. ¡Guarda los que te interesen para
                            encontrarlos fácil después!
                        </p>
                    </div>
                </div>
            </div>

            {{-- Buscador y filtros --}}
            <form method="GET" action="{{ route('cursos') }}" class="mb-6 rounded-lg bg-white p-6 shadow-sm">
                @if ($vista !== 'todos')
                    <input type="hidden" name="vista" value="{{ $vista }}">
                @endif

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="relative">
                        <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar cursos..." class="oj-input pl-10">
                    </div>

                    <select name="categoria" class="oj-input" onchange="this.form.submit()">
                        <option value="">Todas las categorías</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria }}" @selected(request('categoria') === $categoria)>{{ $categoria }}</option>
                        @endforeach
                    </select>

                    <select name="modalidad" class="oj-input" onchange="this.form.submit()">
                        <option value="">Todas las modalidades</option>
                        @foreach ($modalidades as $modalidad)
                            <option value="{{ $modalidad }}" @selected(request('modalidad') === $modalidad)>{{ $modalidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex gap-2">
                        <button type="submit" class="oj-btn-primary oj-btn-sm">
                            <x-icon name="search" class="h-4 w-4" />
                            Buscar
                        </button>
                        @if (request()->hasAny(['q', 'categoria', 'modalidad']))
                            <a href="{{ route('cursos', $vista !== 'todos' ? ['vista' => $vista] : []) }}" class="oj-btn-ghost oj-btn-sm">Limpiar</a>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600">{{ $cursos->total() }} {{ $cursos->total() === 1 ? 'curso encontrado' : 'cursos encontrados' }}</p>
                </div>
            </form>

            {{-- Pestañas --}}
            <div class="mb-6 grid h-9 w-full max-w-md grid-cols-3 rounded-xl bg-oj-bg p-[3px]">
                @foreach ($pestanas as $clave => $titulo)
                    <a href="{{ route('cursos', array_filter(array_merge(request()->except(['page', 'vista']), ['vista' => $clave === 'todos' ? null : $clave]))) }}"
                       class="flex items-center justify-center rounded-xl text-sm font-medium transition
                       {{ $vista === $clave ? 'bg-white text-oj-primary shadow-sm' : 'text-oj-primary/70 hover:text-oj-primary' }}">
                        {{ $titulo }}
                    </a>
                @endforeach
            </div>

            {{-- Tarjetas --}}
            @if ($cursos->count())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($cursos as $curso)
                        @php
                            $guardado = $guardadosIds->contains($curso->id);
                            $inicio = $curso->fecha_inicio;
                            $temas = $curso->temas ?? [];
                        @endphp

                        <div class="oj-card flex flex-col gap-6 transition-shadow hover:shadow-lg">

                            <div class="px-6 pt-6">
                                <div class="mb-3 flex items-start justify-between gap-2">
                                    <span class="oj-badge bg-green-100 text-green-700">Gratuito</span>
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <span class="oj-badge-outline">{{ $curso->modalidad }}</span>
                                        <span class="oj-badge-outline">{{ $curso->nivel }}</span>
                                    </div>
                                </div>
                                <h4 class="text-lg leading-tight">{{ $curso->titulo }}</h4>
                                <p class="mt-1.5 text-sm text-oj-muted">{{ $curso->institucion }}</p>
                            </div>

                            <div class="flex flex-1 flex-col px-6 pb-6">
                                <p class="mb-4 line-clamp-2 text-sm text-gray-600" title="{{ $curso->descripcion }}">{{ $curso->descripcion }}</p>

                                <div class="mb-4 space-y-2 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <x-icon name="clock" class="h-4 w-4" />
                                        <span class="text-xs">{{ $curso->duracion ?? 'Duración a consultar' }}@if ($curso->horario) • {{ $curso->horario }}@endif</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <x-icon name="calendar" class="h-4 w-4" />
                                        <span class="text-xs">{{ $inicio ? $inicio->day . ' de ' . $meses[$inicio->month - 1] . ' ' . $inicio->year : 'Inscripción abierta, empiezas cuando quieras' }}</span>
                                    </div>

                                    @if ($curso->cupos !== null)
                                        <div class="flex items-center gap-2">
                                            <x-icon name="users" class="h-4 w-4" />
                                            <span class="text-xs">{{ $curso->cupos }} cupos disponibles</span>
                                        </div>
                                    @endif

                                    @if ($curso->certificado)
                                        <div class="flex items-center gap-2">
                                            <x-icon name="award" class="h-4 w-4 text-blue-600" />
                                            <span class="text-xs text-blue-600">Con certificado</span>
                                        </div>
                                    @endif
                                </div>

                                @if (count($temas))
                                    <div class="mb-4">
                                        <p class="mb-2 text-xs text-gray-700">Temas:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach (array_slice($temas, 0, 3) as $tema)
                                                <span class="oj-badge-secondary">{{ $tema }}</span>
                                            @endforeach
                                            @if (count($temas) > 3)
                                                <span class="oj-badge-secondary" title="{{ implode(', ', array_slice($temas, 3)) }}">+{{ count($temas) - 3 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-auto space-y-2">
                                    @auth
                                        @if ($curso->url_inscripcion)
                                            <a href="{{ $curso->url_inscripcion }}" target="_blank" rel="noopener noreferrer" class="{{ $degradado }}">
                                                Inscribirse
                                                <x-icon name="external-link" class="h-4 w-4" />
                                            </a>
                                        @endif

                                        @if ($curso->contacto)
                                            <p class="text-center text-xs text-gray-600">Contacto: {{ $curso->contacto }}</p>
                                        @endif

                                        <form method="POST" action="{{ route('cursos.guardar', $curso) }}">
                                            @csrf
                                            <button type="submit" class="oj-btn-outline w-full">
                                                <x-icon name="bookmark" class="h-4 w-4" :fill="$guardado ? 'currentColor' : 'none'" />
                                                {{ $guardado ? 'Guardado' : 'Guardar curso' }}
                                            </button>
                                        </form>

                                        @if ($curso->url_inscripcion)
                                            <p class="text-center text-xs text-gray-500">Te llevaremos a la página del curso. Allí te inscribes.</p>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="{{ $degradado }}">Ingresa para inscribirte</a>
                                        <a href="{{ route('login') }}" class="oj-btn-outline w-full">
                                            <x-icon name="bookmark" class="h-4 w-4" />
                                            Guardar curso
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $cursos->links() }}
                </div>
            @else
                <div class="py-12 text-center text-gray-500">
                    <x-icon name="book-open" class="mx-auto mb-4 h-12 w-12 text-gray-400" />

                    @if ($vista === 'guardados')
                        @guest
                            <p>Ingresa para ver los cursos que guardes.</p>
                            <a href="{{ route('login') }}" class="mt-3 inline-block text-sm font-medium text-oj-accent hover:underline">Ingresar</a>
                        @else
                            <p>No tienes cursos guardados</p>
                        @endguest
                    @elseif ($vista === 'proximos')
                        <p>No hay cursos con fecha de inicio programada.</p>
                        <p class="mt-1 text-sm">Los cursos de la pestaña «Todos» tienen inscripción abierta: puedes empezar cuando quieras.</p>
                    @else
                        <p>No hay cursos con esos filtros.</p>
                    @endif
                </div>
            @endif

        </div>
    </div>

</x-app-layout>
