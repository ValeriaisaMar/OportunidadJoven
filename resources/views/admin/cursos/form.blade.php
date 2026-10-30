<x-app-layout>

    @php
        $input = 'w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-[#10375d] focus:border-[#05647a] focus:ring-[#05647a]';
        $etiqueta = 'mb-1 block text-sm font-medium text-gray-700';

        $modalidades = \App\Models\Curso::MODALIDADES;
        $niveles = \App\Models\Curso::NIVELES;
    @endphp

    <section class="oj-section py-10">
        <div class="oj-container max-w-3xl">

            @include('admin._menu')

            <h1 class="mb-6 text-2xl font-bold text-[#10375d]">
                {{ $curso->exists ? 'Editar curso' : 'Nuevo curso' }}
            </h1>

            <form method="POST"
                  action="{{ $curso->exists ? route('admin.cursos.update', $curso) : route('admin.cursos.store') }}"
                  class="space-y-5 rounded-xl border border-gray-300 bg-white p-6">
                @csrf
                @if ($curso->exists)
                    @method('PUT')
                @endif

                <div>
                    <label class="{{ $etiqueta }}">Nombre del curso</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $curso->titulo) }}" class="{{ $input }}">
                    @error('titulo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Institución</label>
                        <input type="text" name="institucion" value="{{ old('institucion', $curso->institucion) }}" class="{{ $input }}">
                        @error('institucion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Categoría (opcional)</label>
                        <input type="text" name="categoria" value="{{ old('categoria', $curso->categoria) }}" placeholder="Tecnología, Idiomas, Ventas..." class="{{ $input }}">
                        @error('categoria') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Modalidad</label>
                        <select name="modalidad" class="{{ $input }}">
                            @foreach ($modalidades as $opcion)
                                <option value="{{ $opcion }}" @selected(old('modalidad', $curso->modalidad ?? 'Online') === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @error('modalidad') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Nivel</label>
                        <select name="nivel" class="{{ $input }}">
                            @foreach ($niveles as $opcion)
                                <option value="{{ $opcion }}" @selected(old('nivel', $curso->nivel ?? 'Principiante') === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @error('nivel') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Duración (opcional)</label>
                        <input type="text" name="duracion" value="{{ old('duracion', $curso->duracion) }}" placeholder="3 meses, 40 horas..." class="{{ $input }}">
                        @error('duracion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Horario (opcional)</label>
                        <input type="text" name="horario" value="{{ old('horario', $curso->horario) }}" placeholder="Lunes y miércoles 6:00-8:00 p. m." class="{{ $input }}">
                        @error('horario') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Fecha de inicio (opcional)</label>
                        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $curso->fecha_inicio?->format('Y-m-d')) }}" class="{{ $input }}">
                        @error('fecha_inicio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Cupos disponibles (opcional)</label>
                        <input type="number" name="cupos" min="0" value="{{ old('cupos', $curso->cupos) }}" class="{{ $input }}">
                        @error('cupos') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="certificado" value="1" @checked(old('certificado', $curso->certificado))
                           class="rounded border-gray-300 text-[#05647a] focus:ring-[#05647a]">
                    El curso entrega certificado
                </label>

                <div>
                    <label class="{{ $etiqueta }}">Descripción</label>
                    <textarea name="descripcion" rows="4" class="{{ $input }}">{{ old('descripcion', $curso->descripcion) }}</textarea>
                    @error('descripcion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $etiqueta }}">Temas (uno por línea)</label>
                    <textarea name="temas" rows="4" class="{{ $input }}">{{ old('temas', $curso->temas ? implode("\n", $curso->temas) : '') }}</textarea>
                    @error('temas') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4 border-t border-gray-200 pt-5">
                    <div>
                        <p class="font-medium text-[#10375d]">¿Cómo se inscribe?</p>
                        <p class="text-sm text-gray-500">Completa al menos uno de los dos. Usa siempre la vía que indica la institución.</p>
                    </div>

                    <div>
                        <label class="{{ $etiqueta }}">Enlace de inscripción</label>
                        <input type="text" name="url_inscripcion" value="{{ old('url_inscripcion', $curso->url_inscripcion) }}" placeholder="https://..." class="{{ $input }}">
                        @error('url_inscripcion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="{{ $etiqueta }}">Contacto (correo, teléfono o WhatsApp)</label>
                        <input type="text" name="contacto" value="{{ old('contacto', $curso->contacto) }}" placeholder="cursos@institucion.edu.co" class="{{ $input }}">
                        @error('contacto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:w-1/2">
                        <label class="{{ $etiqueta }}">Fecha de cierre de inscripciones (opcional)</label>
                        <input type="date" name="fecha_cierre" value="{{ old('fecha_cierre', $curso->fecha_cierre?->format('Y-m-d')) }}" class="{{ $input }}">
                        <p class="mt-1 text-xs text-gray-500">Pasada esta fecha, el curso deja de aparecer en el sitio.</p>
                        @error('fecha_cierre') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="rounded-md bg-[#10375d] px-5 py-2 text-sm font-medium text-white hover:bg-[#05647a]">
                        Guardar
                    </button>
                    <a href="{{ route('admin.cursos.index') }}" class="rounded-md border border-gray-300 px-5 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
