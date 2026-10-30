<x-app-layout>

    <section class="oj-section py-10">
        <div class="oj-container">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#10375d] mb-2">Pasantías y Programas Trainee</h1>
                <p class="text-gray-600">Aprende mientras trabajas con las mejores empresas</p>
            </div>

            {{-- Qué es una pasantía --}}
            <div class="mb-6 rounded-lg border border-[#6db8bb]/50 bg-white p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg text-2xl"
                         style="background-color: rgba(109, 184, 187, 0.2);">🎓</div>
                    <div>
                        <h3 class="mb-2 text-lg font-semibold text-[#10375d]">¿Qué es una pasantía?</h3>
                        <p class="text-sm text-gray-600">
                            Las pasantías son programas de formación práctica donde estudiantes y recién graduados
                            adquieren experiencia laboral mientras reciben capacitación. Los programas trainee están
                            pensados para formar futuros profesionales con un plan de carrera definido.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Pestañas por tipo --}}
            <div class="mb-6 grid max-w-md grid-cols-3 rounded-xl p-[3px]" style="background-color: #e0e2d5;">
                @php
                    $pestanas = [
                        ['clave' => null, 'titulo' => 'Todas', 'cantidad' => $total],
                        ['clave' => 'Pasantía', 'titulo' => 'Pasantías', 'cantidad' => $conteos['Pasantía'] ?? 0],
                        ['clave' => 'Trainee', 'titulo' => 'Trainee', 'cantidad' => $conteos['Trainee'] ?? 0],
                    ];
                @endphp

                @foreach ($pestanas as $pestana)
                    <a href="{{ route('pasantias', array_filter(array_merge(request()->except(['page', 'tipo']), ['tipo' => $pestana['clave']]))) }}"
                       class="rounded-xl py-1.5 text-center text-sm font-medium transition
                       {{ $tipoActivo === $pestana['clave'] ? 'bg-white text-[#10375d] shadow-sm' : 'text-[#10375d]/60 hover:text-[#10375d]' }}">
                        {{ $pestana['titulo'] }} ({{ $pestana['cantidad'] }})
                    </a>
                @endforeach
            </div>

            {{-- Buscador y filtros --}}
            <form method="GET" action="{{ route('pasantias') }}" class="bg-white rounded-lg shadow-sm p-6 mb-6">
                @if ($tipoActivo)
                    <input type="hidden" name="tipo" value="{{ $tipoActivo }}">
                @endif

                <div class="grid md:grid-cols-3 gap-4 mb-4">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar pasantía o empresa..."
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6db8bb]"
                    >

                    <select name="ubicacion" class="rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="Todas las ubicaciones">Todas las ubicaciones</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion }}" @selected(request('ubicacion') === $ubicacion)>{{ $ubicacion }}</option>
                        @endforeach
                    </select>

                    <select name="duracion" class="rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="">Todas las duraciones</option>
                        @foreach ($duraciones as $valor => $texto)
                            <option value="{{ $valor }}" @selected(request('duracion') === $valor)>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                        Buscar
                    </button>
                    <p class="text-sm text-gray-600">{{ $pasantias->total() }} pasantías encontradas</p>
                </div>
            </form>

            {{-- Listado --}}
            <div class="space-y-4">
                @forelse ($pasantias as $pasantia)
                    <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow p-6">

                        <div class="flex items-center gap-2 mb-2">
                            <span class="rounded-md px-2 py-0.5 text-xs font-medium
                                {{ $pasantia->tipo === 'Pasantía' ? 'bg-[#6db8bb]/25 text-[#10375d]' : 'bg-blue-100 text-blue-700' }}">
                                {{ $pasantia->tipo }}
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">{{ $pasantia->created_at->diffForHumans() }}</span>
                        </div>

                        <h2 class="text-xl font-semibold text-[#10375d] mb-1">{{ $pasantia->titulo }}</h2>
                        <p class="text-gray-600">🏢 {{ $pasantia->empresa }}</p>

                        <p class="text-sm text-gray-600 my-4">{{ $pasantia->descripcion }}</p>

                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4 text-sm text-gray-600">
                            <div>📍 {{ $pasantia->ubicacion }} · {{ $pasantia->modalidad }}</div>
                            <div>⏱️ {{ $pasantia->duracion_meses ? $pasantia->duracion_meses . ($pasantia->duracion_meses === 1 ? ' mes' : ' meses') : 'Duración a consultar' }}</div>
                            <div>📅 {{ $pasantia->fecha_inicio ? 'Inicia el ' . $pasantia->fecha_inicio->format('d/m/Y') : 'Inicio a consultar' }}</div>
                            <div>🕒 {{ $pasantia->horario ?? 'Horario a consultar' }}</div>
                        </div>

                        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3">
                            <p class="text-sm text-green-800">
                                <strong>Apoyo económico:</strong> {{ $pasantia->estipendio ?? 'A consultar en la convocatoria' }}
                            </p>
                        </div>

                        @if ($pasantia->fecha_cierre)
                            <p class="mb-2 text-sm text-gray-600">⏳ Cierra el {{ $pasantia->fecha_cierre->format('d/m/Y') }}</p>
                        @endif

                        @auth
                            @if ($pasantia->contacto)
                                <p class="mb-4 text-sm text-gray-600">✉️ Contacto: {{ $pasantia->contacto }}</p>
                            @endif
                        @endauth

                        @if ($pasantia->requisitos)
                            <div class="mb-4">
                                <p class="text-sm text-gray-700 mb-2">Requisitos:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($pasantia->requisitos as $requisito)
                                        <span class="rounded-md bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $requisito }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($pasantia->beneficios)
                            <div class="mb-4">
                                <p class="text-sm text-gray-700 mb-2">Beneficios:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($pasantia->beneficios as $beneficio)
                                        <span class="rounded-md bg-blue-50 px-2 py-0.5 text-xs text-blue-700">{{ $beneficio }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-3">
                            @auth
                                @if ($pasantia->url_postulacion)
                                    <a href="{{ $pasantia->url_postulacion }}" target="_blank" rel="noopener noreferrer"
                                       class="flex-1 rounded-md bg-[#10375d] py-2 text-center text-sm font-medium text-white hover:bg-[#05647a]">
                                        Postularme en la convocatoria
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex-1 rounded-md bg-[#10375d] py-2 text-center text-sm font-medium text-white hover:bg-[#05647a]">
                                    Ingresa para postularte
                                </a>
                            @endauth

                            <button class="rounded-md border border-gray-300 text-sm font-medium px-4 py-2 text-[#10375d] hover:bg-gray-50">
                                Ver detalles
                            </button>
                        </div>

                        @auth
                            @if ($pasantia->url_postulacion)
                                <p class="mt-3 text-xs text-gray-500">
                                    Te llevaremos a la página de la convocatoria. Allí haces la postulación.
                                </p>
                            @endif
                        @endauth
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-12">No hay pasantías publicadas con esos filtros.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $pasantias->links() }}
            </div>

        </div>
    </section>

</x-app-layout>
