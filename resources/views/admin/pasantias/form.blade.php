<x-app-layout>

    @php
        $input = 'w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-[#10375d] focus:border-[#05647a] focus:ring-[#05647a]';
        $etiqueta = 'mb-1 block text-sm font-medium text-gray-700';

        $tipos = \App\Models\Pasantia::TIPOS;
        $modalidades = \App\Http\Controllers\Admin\PasantiaController::MODALIDADES;
    @endphp

    <section class="oj-section py-10">
        <div class="oj-container max-w-3xl">

            @include('admin._menu')

            <h1 class="mb-6 text-2xl font-bold text-[#10375d]">
                {{ $pasantia->exists ? 'Editar pasantía' : 'Nueva pasantía' }}
            </h1>

            <form method="POST"
                  action="{{ $pasantia->exists ? route('admin.pasantias.update', $pasantia) : route('admin.pasantias.store') }}"
                  class="space-y-5 rounded-xl border border-gray-300 bg-white p-6">
                @csrf
                @if ($pasantia->exists)
                    @method('PUT')
                @endif

                <div>
                    <label class="{{ $etiqueta }}">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $pasantia->titulo) }}" class="{{ $input }}">
                    @error('titulo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $etiqueta }}">Empresa o institución</label>
                    <input type="text" name="empresa" value="{{ old('empresa', $pasantia->empresa) }}" class="{{ $input }}">
                    @error('empresa') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="{{ $etiqueta }}">Tipo</label>
                        <select name="tipo" class="{{ $input }}">
                            @foreach ($tipos as $opcion)
                                <option value="{{ $opcion }}" @selected(old('tipo', $pasantia->tipo ?? 'Pasantía') === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @error('tipo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Ubicación</label>
                        <input type="text" name="ubicacion" value="{{ old('ubicacion', $pasantia->ubicacion) }}" placeholder="Montería" class="{{ $input }}">
                        @error('ubicacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Modalidad</label>
                        <select name="modalidad" class="{{ $input }}">
                            @foreach ($modalidades as $opcion)
                                <option value="{{ $opcion }}" @selected(old('modalidad', $pasantia->modalidad ?? 'Presencial') === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @error('modalidad') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Duración en meses (opcional)</label>
                        <input type="number" name="duracion_meses" min="1" max="36" value="{{ old('duracion_meses', $pasantia->duracion_meses) }}" placeholder="6" class="{{ $input }}">
                        @error('duracion_meses') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Horario (opcional)</label>
                        <input type="text" name="horario" value="{{ old('horario', $pasantia->horario) }}" placeholder="20 horas semanales" class="{{ $input }}">
                        @error('horario') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Apoyo económico (opcional)</label>
                        <input type="text" name="estipendio" value="{{ old('estipendio', $pasantia->estipendio) }}" placeholder="A convenir" class="{{ $input }}">
                        @error('estipendio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Fecha de inicio (opcional)</label>
                        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $pasantia->fecha_inicio?->format('Y-m-d')) }}" class="{{ $input }}">
                        @error('fecha_inicio') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="{{ $etiqueta }}">Descripción</label>
                    <textarea name="descripcion" rows="4" class="{{ $input }}">{{ old('descripcion', $pasantia->descripcion) }}</textarea>
                    @error('descripcion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="{{ $etiqueta }}">Requisitos (uno por línea)</label>
                        <textarea name="requisitos" rows="4" class="{{ $input }}">{{ old('requisitos', $pasantia->requisitos ? implode("\n", $pasantia->requisitos) : '') }}</textarea>
                        @error('requisitos') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="{{ $etiqueta }}">Beneficios (uno por línea)</label>
                        <textarea name="beneficios" rows="4" class="{{ $input }}">{{ old('beneficios', $pasantia->beneficios ? implode("\n", $pasantia->beneficios) : '') }}</textarea>
                        @error('beneficios') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-4 border-t border-gray-200 pt-5">
                    <div>
                        <p class="font-medium text-[#10375d]">¿Cómo se postula?</p>
                        <p class="text-sm text-gray-500">Completa al menos uno de los dos. Usa siempre la vía que indica la convocatoria original.</p>
                    </div>

                    <div>
                        <label class="{{ $etiqueta }}">Enlace de la convocatoria</label>
                        <input type="text" name="url_postulacion" value="{{ old('url_postulacion', $pasantia->url_postulacion) }}" placeholder="https://..." class="{{ $input }}">
                        @error('url_postulacion') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="{{ $etiqueta }}">Contacto (correo, teléfono o WhatsApp)</label>
                        <input type="text" name="contacto" value="{{ old('contacto', $pasantia->contacto) }}" placeholder="practicas@empresa.com" class="{{ $input }}">
                        @error('contacto') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:w-1/2">
                        <label class="{{ $etiqueta }}">Fecha de cierre (opcional)</label>
                        <input type="date" name="fecha_cierre" value="{{ old('fecha_cierre', $pasantia->fecha_cierre?->format('Y-m-d')) }}" class="{{ $input }}">
                        <p class="mt-1 text-xs text-gray-500">Pasada esta fecha, la pasantía deja de aparecer en el sitio.</p>
                        @error('fecha_cierre') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="rounded-md bg-[#10375d] px-5 py-2 text-sm font-medium text-white hover:bg-[#05647a]">
                        Guardar
                    </button>
                    <a href="{{ route('admin.pasantias.index') }}" class="rounded-md border border-gray-300 px-5 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>
