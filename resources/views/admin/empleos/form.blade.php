<x-app-layout>

    @php
        $input = 'w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-[#10375d] focus:border-[#05647a] focus:ring-[#05647a]';
        $etiqueta = 'mb-1 block text-sm font-medium text-gray-700';

        $modalidades = \App\Http\Controllers\Admin\EmpleoController::MODALIDADES;
        $jornadas = \App\Http\Controllers\Admin\EmpleoController::JORNADAS;
        $experiencias = \App\Http\Controllers\Admin\EmpleoController::EXPERIENCIAS;
    @endphp

    <section class="oj-section py-10">
        <div class="oj-container max-w-3xl">

            <h1 class="mb-6 text-2xl font-bold text-[#10375d]">
                {{ $empleo->exists ? 'Editar empleo' : 'Nuevo empleo' }}
            </h1>

            <form method="POST"
                  action="{{ $empleo->exists ? route('admin.empleos.update', $empleo) : route('admin.empleos.store') }}"
                  class="space-y-5 rounded-xl border border-gray-300 bg-white p-6">
                @csrf
                @if ($empleo->exists)
                    @method('PUT')
                @endif

                {{-- Datos del puesto --}}
                <div>
                    <label class="{{ $etiqueta }}">Título del puesto</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $empleo->titulo) }}" class="{{ $input }}">
                    @error('titulo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $etiqueta }}">Empresa</label>
                    <input type="text" name="empresa" value="{{ old('empresa', $empleo->empresa) }}" class="{{ $input }}">
                    @error('empresa') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Ubicación</label>
                        <input type="text" name="ubicacion" value="{{ old('ubicacion', $empleo->ubicacion) }}" placeholder="Montería" class="{{ $input }}">
                        @error('ubicacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Salario (opcional)</label>
                        <input type="text" name="salario" value="{{ old('salario', $empleo->salario) }}" placeholder="A convenir" class="{{ $input }}">
                        @error('salario') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="{{ $etiqueta }}">Modalidad</label>
                        <select name="modalidad" class="{{ $input }}">
                            @foreach ($modalidades as $opcion)
                                <option value="{{ $opcion }}" @selected(old('modalidad', $empleo->modalidad ?? 'Presencial') === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @error('modalidad') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Jornada</label>
                        <select name="jornada" class="{{ $input }}">
                            @foreach ($jornadas as $opcion)
                                <option value="{{ $opcion }}" @selected(old('jornada', $empleo->jornada ?? 'Tiempo completo') === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @error('jornada') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Experiencia</label>
                        <select name="experiencia" class="{{ $input }}">
                            @foreach ($experiencias as $opcion)
                                <option value="{{ $opcion }}" @selected(old('experiencia', $empleo->experiencia ?? 'Sin experiencia') === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @error('experiencia') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="{{ $etiqueta }}">Descripción</label>
                    <textarea name="descripcion" rows="4" class="{{ $input }}">{{ old('descripcion', $empleo->descripcion) }}</textarea>
                    @error('descripcion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $etiqueta }}">Requisitos (uno por línea)</label>
                    <textarea name="requisitos" rows="4" class="{{ $input }}">{{ old('requisitos', $empleo->requisitos ? implode("\n", $empleo->requisitos) : '') }}</textarea>
                    @error('requisitos') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Cómo aplicar --}}
                <div class="space-y-4 border-t border-gray-200 pt-5">
                    <div>
                        <p class="font-medium text-[#10375d]">¿Cómo se aplica?</p>
                        <p class="text-sm text-gray-500">Completa al menos uno de los dos. Usa siempre la vía que indica la convocatoria original.</p>
                    </div>

                    <div>
                        <label class="{{ $etiqueta }}">Enlace de la convocatoria</label>
                        <input type="text" name="url_postulacion" value="{{ old('url_postulacion', $empleo->url_postulacion) }}" placeholder="https://..." class="{{ $input }}">
                        @error('url_postulacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="{{ $etiqueta }}">Contacto (correo, teléfono o WhatsApp)</label>
                        <input type="text" name="contacto" value="{{ old('contacto', $empleo->contacto) }}" placeholder="rrhh@empresa.com" class="{{ $input }}">
                        @error('contacto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:w-1/2">
                        <label class="{{ $etiqueta }}">Fecha de cierre (opcional)</label>
                        <input type="date" name="fecha_cierre" value="{{ old('fecha_cierre', $empleo->fecha_cierre?->format('Y-m-d')) }}" class="{{ $input }}">
                        <p class="mt-1 text-xs text-gray-500">Pasada esta fecha, el empleo deja de aparecer en el sitio.</p>
                        @error('fecha_cierre') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="rounded-md bg-[#10375d] px-5 py-2 text-sm font-medium text-white hover:bg-[#05647a]">
                        Guardar
                    </button>
                    <a href="{{ route('admin.empleos.index') }}" class="rounded-md border border-gray-300 px-5 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
