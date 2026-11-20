<x-app-layout>

    @php
        $iniciales = mb_strtoupper(collect(explode(' ', trim($user->name)))->filter()->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->join(''));
        $hayErrores = $errors->hasAny(['name', 'email', 'telefono', 'ubicacion', 'fecha_nacimiento', 'educacion', 'bio', 'habilidades']);
        $pestanas = ['sobre-mi' => 'Sobre mí', 'aplicaciones' => 'Aplicaciones', 'guardados' => 'Guardados', 'cursos' => 'Cursos'];
        $etiqueta = 'mb-2 block text-sm text-oj-primary';
    @endphp

    <div class="min-h-screen bg-oj-bg" x-data="{ tab: 'sobre-mi', editando: {{ $hayErrores ? 'true' : 'false' }} }">
        <div class="oj-container py-8">

            @if (session('status') === 'perfil-actualizado')
                <div class="mb-6 rounded-md bg-green-100 px-4 py-2 text-sm text-green-700">
                    Tu perfil se actualizó correctamente.
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- ===== Columna izquierda ===== --}}
                <div class="space-y-6 lg:col-span-1">

                    {{-- Tarjeta de perfil --}}
                    <div class="oj-card p-6">
                        <div class="flex flex-col items-center text-center">
                            <div class="mb-4 flex h-24 w-24 items-center justify-center rounded-full text-2xl text-white"
                                 style="background: linear-gradient(135deg, #10375d 0%, #05647a 100%);">
                                {{ $iniciales }}
                            </div>

                            <h2 class="mb-1 text-2xl text-oj-primary">{{ $user->name }}</h2>
                            <p class="mb-4 text-sm text-oj-muted">{{ $user->esAdmin() ? 'Administrador' : 'Estudiante' }}</p>

                            <div class="mb-4 w-full">
                                <div class="mb-2 flex justify-between text-sm">
                                    <span class="text-oj-primary">Perfil completo</span>
                                    <span class="text-oj-accent">{{ $porcentajePerfil }}%</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-oj-bg">
                                    <div class="h-2 rounded-full" style="width: {{ $porcentajePerfil }}%; background: linear-gradient(90deg, #10375d 0%, #05647a 100%);"></div>
                                </div>
                            </div>

                            <button type="button" @click="editando = !editando; tab = 'sobre-mi'" class="oj-btn-gradient mb-3 w-full">
                                <template x-if="!editando">
                                    <span class="inline-flex items-center gap-2"><x-icon name="edit-2" class="h-4 w-4" /> Editar Perfil</span>
                                </template>
                                <template x-if="editando">
                                    <span class="inline-flex items-center gap-2"><x-icon name="x" class="h-4 w-4" /> Cancelar</span>
                                </template>
                            </button>

                            <button x-show="editando" x-cloak type="submit" form="form-perfil" class="oj-btn w-full bg-oj-secondary text-white hover:opacity-90">
                                <x-icon name="save" class="h-4 w-4" />
                                Guardar Cambios
                            </button>
                        </div>

                        <div class="my-6 h-px bg-oj-muted/30"></div>

                        {{-- Contacto --}}
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-3">
                                <x-icon name="mail" class="h-4 w-4 text-oj-accent" />
                                <span class="truncate text-oj-primary">{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-icon name="phone" class="h-4 w-4 text-oj-accent" />
                                <span class="{{ $user->telefono ? 'text-oj-primary' : 'text-oj-muted' }}">{{ $user->telefono ?: 'Agrega tu teléfono' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-icon name="map-pin" class="h-4 w-4 text-oj-accent" />
                                <span class="{{ $user->ubicacion ? 'text-oj-primary' : 'text-oj-muted' }}">{{ $user->ubicacion ?: 'Agrega tu ubicación' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-icon name="calendar" class="h-4 w-4 text-oj-accent" />
                                <span class="{{ $user->fecha_nacimiento ? 'text-oj-primary' : 'text-oj-muted' }}">{{ $user->fecha_nacimiento?->format('d/m/Y') ?: 'Agrega tu fecha de nacimiento' }}</span>
                            </div>
                        </div>

                        <div class="my-6 h-px bg-oj-muted/30"></div>

                        {{-- Habilidades --}}
                        <div>
                            <h3 class="mb-3 text-sm text-oj-primary">Habilidades</h3>
                            @if ($user->habilidades)
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($user->habilidades as $habilidad)
                                        <span class="oj-badge text-oj-primary" style="background-color: rgba(109, 184, 187, 0.2);">{{ $habilidad }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-oj-muted">Aún no agregaste habilidades.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Logros --}}
                    <div class="oj-card p-6">
                        <h4 class="mb-6 flex items-center gap-2 text-base leading-none">
                            <x-icon name="award" class="h-5 w-5 text-oj-accent" />
                            Logros
                        </h4>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach ($logros as $logro)
                                <div class="rounded-lg p-3 text-center {{ $logro['logrado'] ? '' : 'opacity-40 grayscale' }}"
                                     style="background-color: rgba(224, 226, 213, 0.5);"
                                     title="{{ $logro['detalle'] }}{{ $logro['logrado'] ? '' : ' (pendiente)' }}">
                                    <div class="mb-1 text-2xl">{{ $logro['icono'] }}</div>
                                    <p class="text-xs text-oj-primary">{{ $logro['titulo'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ===== Columna derecha: pestañas ===== --}}
                <div class="space-y-6 lg:col-span-2">
                    <div class="grid h-9 w-full grid-cols-4 rounded-xl bg-oj-bg p-[3px]" style="box-shadow: inset 0 0 0 1px rgba(134, 150, 132, 0.25);">
                        @foreach ($pestanas as $clave => $titulo)
                            <button type="button" @click="tab = '{{ $clave }}'"
                                    :class="tab === '{{ $clave }}' ? 'bg-white shadow-sm' : 'hover:bg-white/50'"
                                    class="rounded-xl text-sm text-oj-primary transition">
                                {{ $titulo }}
                            </button>
                        @endforeach
                    </div>

                    {{-- --- Sobre mí --- --}}
                    <div x-show="tab === 'sobre-mi'" class="space-y-6">

                        <div class="oj-card flex flex-col gap-6 py-6">
                            <div class="px-6">
                                <h4 class="leading-none">Información Personal</h4>
                                <p class="mt-1.5 text-oj-muted">Cuéntanos sobre ti y tus objetivos</p>
                            </div>

                            {{-- Vista --}}
                            <div x-show="!editando" class="space-y-4 px-6">
                                <div>
                                    <h3 class="mb-2 text-sm text-oj-muted">Sobre mí</h3>
                                    <p class="text-oj-primary">{{ $user->bio ?: 'Cuéntale a las empresas quién eres y qué te gustaría aprender. Toca «Editar Perfil».' }}</p>
                                </div>
                                <div>
                                    <h3 class="mb-2 text-sm text-oj-muted">Educación</h3>
                                    <div class="flex items-center gap-2">
                                        <x-icon name="graduation-cap" class="h-4 w-4 text-oj-accent" />
                                        <p class="text-oj-primary">{{ $user->educacion ?: 'Sin información todavía' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Edición --}}
                            <form id="form-perfil" x-show="editando" x-cloak method="POST" action="{{ route('profile.update') }}" class="space-y-4 px-6">
                                @csrf
                                @method('PATCH')

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="name" class="{{ $etiqueta }}">Nombre completo</label>
                                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="oj-input">
                                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="email" class="{{ $etiqueta }}">Email</label>
                                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="oj-input">
                                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="telefono" class="{{ $etiqueta }}">Teléfono</label>
                                        <input id="telefono" type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}" class="oj-input">
                                        @error('telefono') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="ubicacion" class="{{ $etiqueta }}">Ubicación</label>
                                        <input id="ubicacion" type="text" name="ubicacion" value="{{ old('ubicacion', $user->ubicacion) }}" placeholder="Ciudad, país" class="oj-input">
                                        @error('ubicacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="fecha_nacimiento" class="{{ $etiqueta }}">Fecha de nacimiento</label>
                                        <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $user->fecha_nacimiento?->format('Y-m-d')) }}" class="oj-input">
                                        @error('fecha_nacimiento') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label for="educacion" class="{{ $etiqueta }}">Educación</label>
                                        <input id="educacion" type="text" name="educacion" value="{{ old('educacion', $user->educacion) }}" placeholder="Institución - Carrera" class="oj-input">
                                        @error('educacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="bio" class="{{ $etiqueta }}">Sobre mí</label>
                                    <textarea id="bio" name="bio" rows="4" class="oj-input">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div x-data="{ habilidades: @js(old('habilidades', $user->habilidades ?? [])), nueva: '' }">
                                    <label for="nueva-habilidad" class="{{ $etiqueta }}">Habilidades</label>
                                    <div class="mb-2 flex flex-wrap gap-2" x-show="habilidades.length">
                                        <template x-for="(habilidad, index) in habilidades" :key="index">
                                            <span class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs text-oj-primary" style="background-color: rgba(109, 184, 187, 0.2);">
                                                <span x-text="habilidad"></span>
                                                <button type="button" @click="habilidades.splice(index, 1)" class="text-oj-muted hover:text-red-600" title="Quitar">
                                                    <x-icon name="x" class="h-3 w-3" />
                                                </button>
                                            </span>
                                        </template>
                                    </div>

                                    <input id="nueva-habilidad" type="text" x-model="nueva"
                                           @keydown.enter.prevent="if (nueva.trim()) { habilidades.push(nueva.trim()); nueva = ''; }"
                                           @keydown.comma.prevent="if (nueva.trim()) { habilidades.push(nueva.trim()); nueva = ''; }"
                                           placeholder="Escribe una habilidad y presiona Enter"
                                           class="oj-input">

                                    <template x-for="(habilidad, index) in habilidades" :key="'campo-' + index">
                                        <input type="hidden" name="habilidades[]" :value="habilidad">
                                    </template>
                                    @error('habilidades.*') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit" class="oj-btn-gradient">
                                        <x-icon name="save" class="h-4 w-4" />
                                        Guardar Cambios
                                    </button>
                                    <button type="button" @click="editando = false" class="oj-btn-outline">Cancelar</button>
                                </div>
                            </form>
                        </div>

                        {{-- Currículum --}}
                        <div class="oj-card flex flex-col gap-6 py-6">
                            <div class="px-6">
                                <h4 class="flex items-center gap-2 text-base leading-none">
                                    <x-icon name="file-text" class="h-5 w-5 text-oj-accent" />
                                    Currículum Vitae
                                </h4>
                            </div>

                            <form method="POST" action="{{ route('profile.cv.update') }}" enctype="multipart/form-data" class="px-6">
                                @csrf
                                @method('PATCH')

                                @if ($user->cv_path)
                                    <div class="mb-3 flex items-center justify-between rounded-lg border border-oj-bg px-4 py-3">
                                        <span class="flex items-center gap-2 text-sm text-oj-primary">
                                            <x-icon name="file-text" class="h-4 w-4 text-oj-accent" />
                                            Ya subiste tu CV
                                        </span>
                                        <a href="{{ Storage::url($user->cv_path) }}" target="_blank" class="text-sm text-oj-accent hover:underline">Ver CV actual</a>
                                    </div>
                                @endif

                                <label class="block cursor-pointer rounded-lg border-2 border-dashed border-oj-muted p-6 text-center transition-colors hover:bg-oj-bg/30">
                                    <input type="file" name="cv" accept=".pdf,.doc,.docx" class="hidden" onchange="this.form.submit()">
                                    <x-icon name="file-text" class="mx-auto mb-3 h-8 w-8 text-oj-muted" />
                                    <p class="mb-3 text-sm text-oj-primary">Arrastra tu CV aquí o haz click para seleccionar</p>
                                    <span class="oj-btn border border-oj-accent bg-white text-oj-accent hover:bg-oj-accent hover:text-white">
                                        <x-icon name="upload" class="h-4 w-4" />
                                        {{ $user->cv_path ? 'Reemplazar archivo' : 'Seleccionar archivo' }}
                                    </span>
                                </label>
                                @error('cv') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </form>
                        </div>
                    </div>

                    {{-- --- Aplicaciones --- --}}
                    <div x-show="tab === 'aplicaciones'" x-cloak class="oj-card flex flex-col gap-6 py-6">
                        <div class="px-6">
                            <h4 class="leading-none">Mis Aplicaciones</h4>
                            <p class="mt-1.5 text-oj-muted">Seguimiento de tus postulaciones</p>
                        </div>
                        <div class="px-6 py-6 text-center">
                            <x-icon name="briefcase" class="mx-auto mb-3 h-10 w-10 text-oj-muted" />
                            <p class="mb-1 text-oj-primary">Las postulaciones se hacen en la página de cada convocatoria.</p>
                            <p class="mb-4 text-sm text-oj-muted">Revisa tu correo para ver las respuestas de las empresas.</p>
                            <div class="flex flex-wrap justify-center gap-3">
                                <a href="{{ route('empleos') }}" class="oj-btn-outline">Ver empleos</a>
                                <a href="{{ route('pasantias') }}" class="oj-btn-outline">Ver pasantías</a>
                            </div>
                        </div>
                    </div>

                    {{-- --- Guardados: cursos guardados de verdad --- --}}
                    <div x-show="tab === 'guardados'" x-cloak class="oj-card flex flex-col gap-6 py-6">
                        <div class="px-6">
                            <h4 class="leading-none">Elementos Guardados</h4>
                            <p class="mt-1.5 text-oj-muted">Los cursos que guardaste para después</p>
                        </div>
                        <div class="space-y-3 px-6">
                            @forelse ($cursosGuardados as $curso)
                                <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-oj-bg bg-white p-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg" style="background-color: rgba(16, 55, 93, 0.1);">
                                            <x-icon name="book-open" class="h-5 w-5 text-oj-primary" />
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="mb-1 truncate text-sm text-oj-primary">{{ $curso->titulo }}</h3>
                                            <p class="text-xs text-oj-muted">{{ $curso->institucion }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        @if ($curso->url_inscripcion)
                                            <a href="{{ $curso->url_inscripcion }}" target="_blank" rel="noopener noreferrer" class="oj-btn oj-btn-sm bg-oj-accent text-white hover:opacity-90">
                                                Inscribirse
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('cursos.guardar', $curso) }}">
                                            @csrf
                                            <button type="submit" class="oj-btn-ghost oj-btn-sm" title="Quitar de guardados">
                                                <x-icon name="x" class="h-4 w-4" />
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center">
                                    <x-icon name="bookmark" class="mx-auto mb-3 h-10 w-10 text-oj-muted" />
                                    <p class="mb-4 text-sm text-oj-muted">Aún no guardaste nada. Usa «Guardar curso» en la página de cursos.</p>
                                    <a href="{{ route('cursos') }}" class="oj-btn-outline">Ver cursos</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- --- Cursos --- --}}
                    <div x-show="tab === 'cursos'" x-cloak class="oj-card flex flex-col gap-6 py-6">
                        <div class="px-6">
                            <h4 class="leading-none">Mis Cursos</h4>
                            <p class="mt-1.5 text-oj-muted">Tu ruta de aprendizaje</p>
                        </div>
                        <div class="space-y-4 px-6">
                            @forelse ($cursosGuardados as $curso)
                                <div class="rounded-lg border border-oj-bg bg-white p-4">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div class="min-w-0 flex-1">
                                            <div class="mb-1 flex flex-wrap items-center gap-2">
                                                <x-icon name="book-open" class="h-4 w-4 text-oj-accent" />
                                                <h3 class="text-base text-oj-primary">{{ $curso->titulo }}</h3>
                                                @if ($curso->certificado)
                                                    <span class="oj-badge border-oj-secondary text-oj-secondary">
                                                        <x-icon name="award" class="h-3 w-3" />
                                                        Certificado
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="mb-2 text-sm text-oj-muted">{{ $curso->institucion }}</p>
                                            <div class="flex flex-wrap items-center gap-4 text-xs text-oj-muted">
                                                <span>Guardado: {{ $curso->pivot->created_at?->format('d/m/Y') }}</span>
                                                @if ($curso->duracion)
                                                    <span>•</span>
                                                    <span>Duración: {{ $curso->duracion }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($curso->url_inscripcion)
                                            <a href="{{ $curso->url_inscripcion }}" target="_blank" rel="noopener noreferrer"
                                               class="oj-btn oj-btn-sm border border-oj-secondary bg-white text-oj-secondary hover:bg-oj-secondary hover:text-white">
                                                Ir al curso
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="py-4 text-center text-sm text-oj-muted">Cuando guardes cursos, aparecerán aquí para que sigas tu avance.</p>
                            @endforelse

                            <div class="mt-6 text-center">
                                <a href="{{ route('cursos') }}" class="oj-btn border border-oj-accent bg-white text-oj-accent hover:bg-oj-accent hover:text-white">
                                    <x-icon name="book-open" class="h-4 w-4" />
                                    Explorar más cursos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
