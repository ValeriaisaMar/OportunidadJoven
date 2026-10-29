<x-app-layout>
    <section class="oj-section py-10">
        <div class="oj-container max-w-2xl">

            <h1 class="text-2xl font-bold text-[#10375d] mb-6">
                {{ $empleo->exists ? 'Editar empleo' : 'Nuevo empleo' }}
            </h1>

            <form method="POST" action="{{ $empleo->exists ? route('admin.empleos.update', $empleo) : route('admin.empleos.store') }}" class="space-y-4 bg-white p-6 rounded-xl border border-gray-200">
                @csrf
                @if ($empleo->exists) @method('PUT') @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título del puesto</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $empleo->titulo) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                    @error('titulo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                    <input type="text" name="empresa" value="{{ old('empresa', $empleo->empresa) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                    @error('empresa') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                        <input type="text" name="ubicacion" value="{{ old('ubicacion', $empleo->ubicacion) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                        @error('ubicacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Salario</label>
                        <input type="text" name="salario" value="{{ old('salario', $empleo->salario) }}" placeholder="A convenir" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Modalidad</label>
                        <select name="modalidad" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                            @foreach (['Presencial', 'Remoto', 'Híbrido'] as $opcion)
                                <option value="{{ $opcion }}" @selected(old('modalidad', $empleo->modalidad) === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jornada</label>
                        <select name="jornada" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                            @foreach (['Tiempo completo', 'Medio tiempo', 'Por proyecto'] as $opcion)
                                <option value="{{ $opcion }}" @selected(old('jornada', $empleo->jornada) === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="4" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('descripcion', $empleo->descripcion) }}</textarea>
                    @error('descripcion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Requisitos (uno por línea)</label>
                    <textarea name="requisitos" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('requisitos', $empleo->requisitos ? implode("\n", $empleo->requisitos) : '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL de imagen (opcional)</label>
                    <input type="text" name="imagen" value="{{ old('imagen', $empleo->imagen) }}" placeholder="https://..." class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="rounded-md bg-[#10375d] text-white text-sm font-medium px-4 py-2 hover:bg-[#10375d]/90">
                        Guardar
                    </button>
                    <a href="{{ route('admin.empleos.index') }}" class="rounded-md border border-gray-300 text-sm font-medium px-4 py-2 text-[#10375d]">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </section>
</x-app-layout>