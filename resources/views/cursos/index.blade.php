<x-app-layout>

    @php
        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

        $pestanas = ['todos' => 'Todos', 'proximos' => 'Próximos', 'guardados' => 'Guardados'];

        $iconoBase = 'h-4 w-4 shrink-0';
    @endphp

    <section class="oj-section py-10">
        <div class="oj-container">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#10375d] mb-2">Cursos Gratuitos Disponibles</h1>
                <p class="text-gray-600">Capacítate con cursos de instituciones reconocidas</p>
            </div>

            {{-- Aviso --}}
            <div class="mb-6 rounded-lg border border-green-200 bg-gradient-to-r from-green-50 to-blue-50 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                    </div>
                    <div>
                        <h3 class="mb-2 text-lg font-semibold text-[#10375d]">Todos los cursos son gratuitos</h3>
                        <p class="text-sm text-gray-600">
                            Estos cursos los ofrecen instituciones educativas. Los que entregan certificado lo indican en
                            su tarjeta, para que puedas agregarlo a tu CV. Guarda los que te interesen para encontrarlos
                            fácil después.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Buscador y filtros --}}
            <form method="GET" action="{{ route('cursos') }}" class="mb-6 rounded-lg bg-white p-6 shadow-sm">
                @if ($vista !== 'todos')
                    <input type="hidden" name="vista" value="{{ $vista }}">
                @endif

                <div class="grid gap-4 md:grid-cols-4">
                    <div class="relative md:col-span-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar cursos..."
                               class="w-full rounded-md border-0 bg-[#e0e2d5] py-2 pl-10 pr-3 text-sm text-[#10375d] placeholder:text-gray-500 focus:ring-2 focus:ring-[#6db8bb]">
                    </div>

                    <select name="categoria" class="rounded-md border-0 bg-[#e0e2d5] px-3 py-2 text-sm text-[#10375d] focus:ring-2 focus:ring-[#6db8bb]">
                        <option value="">Todas las categorías</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria }}" @selected(request('categoria') === $categoria)>{{ $categoria }}</option>
                        @endforeach
                    </select>

                    <select name="modalidad" class="rounded-md border-0 bg-[#e0e2d5] px-3 py-2 text-sm text-[#10375d] focus:ring-2 focus:ring-[#6db8bb]">
                        <option value="">Todas las modalidades</option>
                        @foreach ($modalidades as $modalidad)
                            <option value="{{ $modalidad }}" @selected(request('modalidad') === $modalidad)>{{ $modalidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                        Buscar
                    </button>
                    <p class="text-sm text-gray-600">{{ $cursos->total() }} cursos encontrados</p>
                </div>
            </form>

            {{-- Pestañas --}}
            <div class="mb-6 grid max-w-md grid-cols-3 rounded-xl p-[3px]" style="background-color: #e0e2d5;">
                @foreach ($pestanas as $clave => $titulo)
                    <a href="{{ route('cursos', array_filter(array_merge(request()->except(['page', 'vista']), ['vista' => $clave === 'todos' ? null : $clave]))) }}"
                       class="rounded-xl py-1.5 text-center text-sm font-medium transition
                       {{ $vista === $clave ? 'bg-white text-[#10375d] shadow-sm' : 'text-[#10375d]/60 hover:text-[#10375d]' }}">
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

                        <div class="flex flex-col rounded-xl border border-[#869684]/50 bg-white p-6 transition-shadow hover:shadow-lg">

                            <div class="mb-3 flex items-start justify-between gap-2">
                                <span class="rounded-md bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Gratuito</span>
                                <div class="flex flex-wrap justify-end gap-2">
                                    <span class="rounded-md border border-gray-400 px-2 py-0.5 text-xs text-[#10375d]">{{ $curso->modalidad }}</span>
                                    <span class="rounded-md border border-gray-400 px-2 py-0.5 text-xs text-[#10375d]">{{ $curso->nivel }}</span>
                                </div>
                            </div>

                            <h2 class="text-lg font-medium leading-tight text-[#10375d]">{{ $curso->titulo }}</h2>
                            <p class="mt-1 text-sm text-[#869684]">{{ $curso->institucion }}</p>

                            <p class="my-4 line-clamp-2 text-sm text-gray-600">{{ $curso->descripcion }}</p>

                            <div class="mb-4 space-y-2 text-xs text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconoBase }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span>{{ $curso->duracion ?? 'Duración a consultar' }}@if ($curso->horario) • {{ $curso->horario }}@endif</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconoBase }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                                    <span>{{ $inicio ? $inicio->day . ' de ' . $meses[$inicio->month - 1] . ' ' . $inicio->year : 'Inicio a consultar' }}</span>
                                </div>

                                @if ($curso->cupos !== null)
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconoBase }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        <span>{{ $curso->cupos }} cupos disponibles</span>
                                    </div>
                                @endif

                                @if ($curso->certificado)
                                    <div class="flex items-center gap-2 text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconoBase }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/></svg>
                                        <span>Con certificado</span>
                                    </div>
                                @endif
                            </div>

                            @if (count($temas))
                                <div class="mb-4">
                                    <p class="mb-2 text-xs text-gray-700">Temas:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (array_slice($temas, 0, 3) as $tema)
                                            <span class="rounded-full bg-[#6db8bb] px-2.5 py-0.5 text-xs text-[#10375d]">{{ $tema }}</span>
                                        @endforeach
                                        @if (count($temas) > 3)
                                            <span class="rounded-full bg-[#6db8bb] px-2.5 py-0.5 text-xs text-[#10375d]">+{{ count($temas) - 3 }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="mt-auto space-y-2 pt-2">
                                @auth
                                    @if ($curso->url_inscripcion)
                                        <a href="{{ $curso->url_inscripcion }}" target="_blank" rel="noopener noreferrer"
                                           class="block w-full rounded-md bg-gradient-to-r from-green-600 to-blue-600 py-2 text-center text-sm font-medium text-white hover:from-green-700 hover:to-blue-700">
                                            Inscribirse
                                        </a>
                                        <p class="text-center text-xs text-gray-500">Te llevaremos a la página del curso. Allí te inscribes.</p>
                                    @endif

                                    @if ($curso->contacto)
                                        <p class="text-center text-xs text-gray-600">✉️ Contacto: {{ $curso->contacto }}</p>
                                    @endif

                                    <form method="POST" action="{{ route('cursos.guardar', $curso) }}">
                                        @csrf
                                        <button type="submit"
                                                class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="{{ $guardado ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                                            {{ $guardado ? 'Guardado' : 'Guardar curso' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="block w-full rounded-md bg-gradient-to-r from-green-600 to-blue-600 py-2 text-center text-sm font-medium text-white hover:from-green-700 hover:to-blue-700">
                                        Ingresa para inscribirte
                                    </a>
                                    <a href="{{ route('login') }}"
                                       class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                                        Guardar curso
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $cursos->links() }}
                </div>
            @else
                <div class="py-12 text-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>

                    @if ($vista === 'guardados')
                        @guest
                            <p>Ingresa para ver los cursos que guardes.</p>
                            <a href="{{ route('login') }}" class="mt-3 inline-block text-sm font-medium text-[#05647a] hover:underline">Ingresar</a>
                        @else
                            <p>No tienes cursos guardados.</p>
                        @endguest
                    @else
                        <p>No hay cursos con esos filtros.</p>
                    @endif
                </div>
            @endif

        </div>
    </section>

</x-app-layout>
