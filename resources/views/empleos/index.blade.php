<x-app-layout>
    @php
        $modalidadesElegidas = (array) request('modalidad', []);
    @endphp

    <div class="oj-page">
        <div class="oj-container py-8">

            {{-- Encabezado --}}
            <div class="mb-8">
                <h1 class="oj-title">Búsqueda de Empleos</h1>
                <p class="text-gray-600">Encuentra el trabajo ideal para comenzar tu carrera</p>
            </div>

            {{-- Buscador y filtros --}}
            <form method="GET" action="{{ route('empleos') }}" x-data="{ masFiltros: {{ count($modalidadesElegidas) ? 'true' : 'false' }} }"
                  class="mb-6 rounded-lg bg-white p-6 shadow-sm">
                <div class="mb-4 grid gap-4 md:grid-cols-4">
                    <div class="relative md:col-span-2">
                        <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por título, empresa..."
                               class="oj-input pl-10">
                    </div>

                    <select name="ubicacion" class="oj-input" onchange="this.form.submit()">
                        <option value="Todas las ubicaciones">Todas las ubicaciones</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion }}" @selected(request('ubicacion') === $ubicacion)>{{ $ubicacion }}</option>
                        @endforeach
                    </select>

                    <select name="jornada" class="oj-input" onchange="this.form.submit()">
                        <option value="Todos los tipos">Todos los tipos</option>
                        @foreach ($jornadas as $jornada)
                            <option value="{{ $jornada }}" @selected(request('jornada') === $jornada)>{{ $jornada }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex gap-2">
                        <button type="button" @click="masFiltros = !masFiltros" class="oj-btn-outline oj-btn-sm">
                            <x-icon name="sliders-horizontal" class="h-4 w-4" />
                            <span x-text="masFiltros ? 'Ocultar filtros' : 'Más filtros'">Más filtros</span>
                        </button>
                        <button type="submit" class="oj-btn-primary oj-btn-sm">
                            <x-icon name="search" class="h-4 w-4" />
                            Buscar
                        </button>
                        @if (request()->hasAny(['q', 'ubicacion', 'jornada', 'modalidad']))
                            <a href="{{ route('empleos') }}" class="oj-btn-ghost oj-btn-sm">Limpiar</a>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600">{{ $empleos->total() }} {{ $empleos->total() === 1 ? 'empleo encontrado' : 'empleos encontrados' }}</p>
                </div>

                {{-- Filtros avanzados --}}
                <div x-show="masFiltros" x-cloak class="mt-6 border-t border-gray-200 pt-6">
                    <div class="grid gap-6 md:grid-cols-3">
                        <div>
                            <h4 class="mb-3 text-sm text-gray-700">Modalidad</h4>
                            <div class="space-y-2">
                                @foreach ($modalidades as $modalidad)
                                    <label class="flex cursor-pointer items-center gap-2 text-sm font-normal text-gray-600">
                                        <input type="checkbox" name="modalidad[]" value="{{ $modalidad }}"
                                               @checked(in_array($modalidad, $modalidadesElegidas))
                                               onchange="this.form.submit()"
                                               class="h-4 w-4 rounded border-oj-muted text-oj-primary focus:ring-oj-secondary">
                                        {{ $modalidad }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Listado de empleos --}}
            <div class="space-y-4">
                @forelse ($empleos as $empleo)
                    <div x-data="{ detalles: false }" class="oj-card transition-shadow hover:shadow-md">
                        <div class="flex flex-col md:flex-row">
                            <img src="{{ $empleo->foto_url }}" alt="{{ $empleo->empresa }}"
                                 class="h-48 w-full rounded-t-xl object-cover md:w-48 md:rounded-l-xl md:rounded-tr-none">

                            <div class="flex-1">
                                {{-- Encabezado de la tarjeta --}}
                                <div class="px-6 pt-6">
                                    <div class="mb-2 flex flex-wrap items-center gap-2">
                                        <span class="oj-badge bg-blue-100 text-blue-700">{{ $empleo->experiencia }}</span>
                                        <span class="oj-badge-outline">{{ $empleo->jornada }}</span>
                                        <span class="oj-badge-outline">{{ $empleo->modalidad }}</span>
                                        <span class="ml-auto text-xs text-gray-500">{{ $empleo->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="mb-2 text-xl leading-tight">{{ $empleo->titulo }}</h4>
                                    <p class="text-base text-oj-muted">{{ $empleo->empresa }}</p>
                                </div>

                                {{-- Contenido --}}
                                <div class="px-6 pb-6 pt-6">
                                    <p class="mb-4 text-sm text-gray-600" :class="detalles ? '' : 'line-clamp-2'">{{ $empleo->descripcion }}</p>

                                    <div class="mb-4 grid gap-3 sm:grid-cols-2">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <x-icon name="map-pin" class="h-4 w-4" />
                                            {{ $empleo->ubicacion }}
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <x-icon name="dollar-sign" class="h-4 w-4" />
                                            {{ $empleo->salario ?? 'A convenir' }}
                                        </div>
                                        @if ($empleo->fecha_cierre)
                                            <div x-show="detalles" x-cloak class="flex items-center gap-2 text-sm text-gray-600">
                                                <x-icon name="calendar" class="h-4 w-4" />
                                                Recibe postulaciones hasta el {{ $empleo->fecha_cierre->format('d/m/Y') }}
                                            </div>
                                        @endif
                                        @auth
                                            @if ($empleo->contacto)
                                                <div x-show="detalles" x-cloak class="flex items-center gap-2 text-sm text-gray-600">
                                                    <x-icon name="mail" class="h-4 w-4" />
                                                    {{ $empleo->contacto }}
                                                </div>
                                            @endif
                                        @endauth
                                    </div>

                                    @if ($empleo->requisitos)
                                        <div class="mb-4">
                                            <p class="mb-2 text-sm text-gray-700">Requisitos:</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($empleo->requisitos as $i => $requisito)
                                                    <span class="oj-badge-secondary whitespace-normal text-left"
                                                          @if ($i >= 3) x-show="detalles" x-cloak @endif>{{ $requisito }}</span>
                                                @endforeach
                                                @if (count($empleo->requisitos) > 3)
                                                    <span x-show="!detalles" class="oj-badge-secondary">+{{ count($empleo->requisitos) - 3 }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex gap-3">
                                        @auth
                                            @if ($empleo->url_postulacion)
                                                <a href="{{ $empleo->url_postulacion }}" target="_blank" rel="noopener noreferrer" class="oj-btn-primary flex-1">
                                                    Aplicar ahora
                                                    <x-icon name="external-link" class="h-4 w-4" />
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="oj-btn-primary flex-1">Ingresa para aplicar</a>
                                        @endauth

                                        <button type="button" @click="detalles = !detalles" class="oj-btn-outline">
                                            <span x-text="detalles ? 'Ver menos' : 'Ver detalles'">Ver detalles</span>
                                        </button>
                                    </div>

                                    @auth
                                        @if ($empleo->url_postulacion)
                                            <p class="mt-3 text-xs text-gray-500">Te llevaremos a la página de la convocatoria. Allí haces la postulación.</p>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500">
                        <x-icon name="briefcase" class="mx-auto mb-4 h-12 w-12 text-gray-400" />
                        <p>No hay empleos con esos filtros.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $empleos->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
