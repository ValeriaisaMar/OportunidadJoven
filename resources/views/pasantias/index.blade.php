<x-app-layout>
    @php
        $pestanas = [
            ['clave' => null, 'titulo' => 'Todas', 'cantidad' => $total],
            ['clave' => 'Pasantía', 'titulo' => 'Pasantías', 'cantidad' => $conteos['Pasantía'] ?? 0],
            ['clave' => 'Trainee', 'titulo' => 'Trainee', 'cantidad' => $conteos['Trainee'] ?? 0],
        ];
    @endphp

    <div class="oj-page">
        <div class="oj-container py-8">

            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="oj-title">Pasantías y Programas Trainee</h1>
                <p class="text-gray-600">Aprende mientras trabajas con las mejores empresas</p>
            </div>

            {{-- Qué es una pasantía --}}
            <div class="mb-6 rounded-lg border border-purple-200 bg-gradient-to-r from-purple-50 to-blue-50 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-purple-100">
                        <x-icon name="graduation-cap" class="h-6 w-6 text-purple-600" />
                    </div>
                    <div>
                        <h3 class="mb-2 text-lg text-gray-900">¿Qué es una pasantía?</h3>
                        <p class="text-sm text-gray-600">
                            Las pasantías son programas de formación práctica donde estudiantes y recién graduados
                            pueden adquirir experiencia laboral mientras reciben capacitación. Los programas trainee
                            están diseñados para desarrollar futuros profesionales con un plan de carrera definido.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Pestañas por tipo --}}
            <div class="mb-6 grid h-9 w-full max-w-md grid-cols-3 rounded-xl bg-oj-bg p-[3px]">
                @foreach ($pestanas as $pestana)
                    <a href="{{ route('pasantias', array_filter(array_merge(request()->except(['page', 'tipo']), ['tipo' => $pestana['clave']]))) }}"
                       class="flex items-center justify-center rounded-xl text-sm font-medium transition
                       {{ $tipoActivo === $pestana['clave'] ? 'bg-white text-oj-primary shadow-sm' : 'text-oj-primary/70 hover:text-oj-primary' }}">
                        {{ $pestana['titulo'] }} ({{ $pestana['cantidad'] }})
                    </a>
                @endforeach
            </div>

            {{-- Buscador y filtros --}}
            <form method="GET" action="{{ route('pasantias') }}" class="mb-6 rounded-lg bg-white p-6 shadow-sm">
                @if ($tipoActivo)
                    <input type="hidden" name="tipo" value="{{ $tipoActivo }}">
                @endif

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="relative">
                        <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar pasantía..." class="oj-input pl-10">
                    </div>

                    <select name="ubicacion" class="oj-input" onchange="this.form.submit()">
                        <option value="Todas las ubicaciones">Todas las ubicaciones</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion }}" @selected(request('ubicacion') === $ubicacion)>{{ $ubicacion }}</option>
                        @endforeach
                    </select>

                    <select name="duracion" class="oj-input" onchange="this.form.submit()">
                        <option value="">Todas las duraciones</option>
                        @foreach ($duraciones as $valor => $texto)
                            <option value="{{ $valor }}" @selected(request('duracion') === $valor)>{{ $texto }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex gap-2">
                        <button type="submit" class="oj-btn-primary oj-btn-sm">
                            <x-icon name="search" class="h-4 w-4" />
                            Buscar
                        </button>
                        @if (request()->hasAny(['q', 'ubicacion', 'duracion']))
                            <a href="{{ route('pasantias', array_filter(['tipo' => $tipoActivo])) }}" class="oj-btn-ghost oj-btn-sm">Limpiar</a>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600">{{ $pasantias->total() }} {{ $pasantias->total() === 1 ? 'pasantía encontrada' : 'pasantías encontradas' }}</p>
                </div>
            </form>

            {{-- Listado --}}
            <div class="space-y-4">
                @forelse ($pasantias as $pasantia)
                    <div x-data="{ detalles: false }" class="oj-card transition-shadow hover:shadow-md">
                        <div class="flex flex-col md:flex-row">
                            <img src="{{ $pasantia->foto_url }}" alt="{{ $pasantia->empresa }}"
                                 class="h-48 w-full rounded-t-xl object-cover md:w-48 md:rounded-l-xl md:rounded-tr-none">

                            <div class="flex-1">
                                <div class="px-6 pt-6">
                                    <div class="mb-2 flex items-center gap-2">
                                        <span class="oj-badge {{ $pasantia->tipo === 'Pasantía' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $pasantia->tipo }}
                                        </span>
                                        <span class="oj-badge-outline">{{ $pasantia->modalidad }}</span>
                                        <span class="ml-auto text-xs text-gray-500">{{ $pasantia->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="mb-2 text-xl leading-tight">{{ $pasantia->titulo }}</h4>
                                    <p class="flex items-center gap-2 text-base text-oj-muted">
                                        <x-icon name="building" class="h-4 w-4" />
                                        {{ $pasantia->empresa }}
                                    </p>
                                </div>

                                <div class="px-6 pb-6 pt-6">
                                    <p class="mb-4 text-sm text-gray-600" :class="detalles ? '' : 'line-clamp-2'">{{ $pasantia->descripcion }}</p>

                                    <div class="mb-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <x-icon name="map-pin" class="h-4 w-4" />
                                            {{ $pasantia->ubicacion }}
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <x-icon name="clock" class="h-4 w-4" />
                                            {{ $pasantia->duracion_meses ? $pasantia->duracion_meses . ($pasantia->duracion_meses === 1 ? ' mes' : ' meses') : 'Duración a consultar' }}
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <x-icon name="calendar" class="h-4 w-4" />
                                            @if ($pasantia->fecha_inicio)
                                                Inicia el {{ $pasantia->fecha_inicio->format('d/m/Y') }}
                                            @elseif ($pasantia->fecha_cierre)
                                                Postúlate hasta el {{ $pasantia->fecha_cierre->format('d/m/Y') }}
                                            @else
                                                Inicio a consultar
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <x-icon name="graduation-cap" class="h-4 w-4" />
                                            <span class="line-clamp-1" title="{{ $pasantia->horario }}">{{ $pasantia->horario ?? 'Horario a consultar' }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3">
                                        <p class="text-sm text-green-800">
                                            <strong>Estipendio:</strong> {{ $pasantia->estipendio ?? 'A consultar en la convocatoria' }}
                                        </p>
                                    </div>

                                    @if ($pasantia->beneficios)
                                        <div class="mb-4">
                                            <p class="mb-2 text-sm text-gray-700">Beneficios:</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($pasantia->beneficios as $beneficio)
                                                    <span class="oj-badge whitespace-normal bg-blue-50 text-left text-blue-700">{{ $beneficio }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Detalles: requisitos, cierre y contacto --}}
                                    <div x-show="detalles" x-cloak>
                                        @if ($pasantia->requisitos)
                                            <div class="mb-4">
                                                <p class="mb-2 text-sm text-gray-700">Requisitos:</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($pasantia->requisitos as $requisito)
                                                        <span class="oj-badge-secondary whitespace-normal text-left">{{ $requisito }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if ($pasantia->fecha_cierre)
                                            <p class="mb-2 flex items-center gap-2 text-sm text-gray-600">
                                                <x-icon name="calendar" class="h-4 w-4" />
                                                Recibe postulaciones hasta el {{ $pasantia->fecha_cierre->format('d/m/Y') }}
                                            </p>
                                        @endif

                                        @auth
                                            @if ($pasantia->contacto)
                                                <p class="mb-4 flex items-center gap-2 text-sm text-gray-600">
                                                    <x-icon name="mail" class="h-4 w-4" />
                                                    {{ $pasantia->contacto }}
                                                </p>
                                            @endif
                                        @endauth
                                    </div>

                                    <div class="flex gap-3">
                                        @auth
                                            @if ($pasantia->url_postulacion)
                                                <a href="{{ $pasantia->url_postulacion }}" target="_blank" rel="noopener noreferrer"
                                                   class="oj-btn flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white hover:from-purple-700 hover:to-blue-700">
                                                    Postularme
                                                    <x-icon name="external-link" class="h-4 w-4" />
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}"
                                               class="oj-btn flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white hover:from-purple-700 hover:to-blue-700">
                                                Ingresa para postularte
                                            </a>
                                        @endauth

                                        <button type="button" @click="detalles = !detalles" class="oj-btn-outline">
                                            <span x-text="detalles ? 'Ver menos' : 'Ver detalles'">Ver detalles</span>
                                        </button>
                                    </div>

                                    @auth
                                        @if ($pasantia->url_postulacion)
                                            <p class="mt-3 text-xs text-gray-500">Te llevaremos a la página de la convocatoria. Allí haces la postulación.</p>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500">
                        <x-icon name="graduation-cap" class="mx-auto mb-4 h-12 w-12 text-gray-400" />
                        <p>No hay pasantías publicadas con esos filtros.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $pasantias->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
