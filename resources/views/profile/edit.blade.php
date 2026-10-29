<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#10375d] leading-tight">Mi Perfil</h2>
    </x-slot>

    @php
        $iniciales = collect(explode(' ', $user->name))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->join('');
    @endphp

    <div class="oj-section py-10" x-data="{ tab: 'sobre-mi' }">
        <div class="oj-container">

            @if (session('status') === 'perfil-actualizado')
                <div class="mb-6 rounded-md bg-green-100 text-green-700 text-sm px-4 py-2">
                    Tu perfil se actualizó correctamente.
                </div>
            @endif

            <div class="grid lg:grid-cols-[320px_1fr] gap-8">

                {{-- ===== Columna izquierda: tarjeta de perfil ===== --}}
                <div class="space-y-6">

                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <div class="h-20 w-20 rounded-full bg-[#10375d] text-white text-xl font-semibold flex items-center justify-center mx-auto mb-4">
                            {{ $iniciales }}
                        </div>
                        <p class="font-semibold text-[#10375d]">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500 mb-4">{{ $user->rol === 'admin' ? 'Administrador' : 'Estudiante' }}</p>

                        <div class="text-left mb-4">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Perfil completo</span>
                                <span>{{ $porcentajePerfil }}%</span>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-gray-200">
                                <div class="h-1.5 rounded-full bg-[#6db8bb]" style="width: {{ $porcentajePerfil }}%"></div>
                            </div>
                        </div>

                        <a href="#sobre-mi" @click="tab = 'sobre-mi'" class="block w-full rounded-md bg-[#10375d] text-white text-sm font-medium py-2 hover:bg-[#10375d]/90">
                            Editar Perfil
                        </a>

                        <div class="text-left text-sm text-gray-600 mt-6 space-y-2 border-t border-gray-100 pt-4">
                            <p class="flex items-center gap-2"><x-icon name="mail" class="h-4 w-4 text-gray-400" /> {{ $user->email }}</p>
                            @if ($user->telefono)
                                <p class="flex items-center gap-2"><x-icon name="phone" class="h-4 w-4 text-gray-400" /> {{ $user->telefono }}</p>
                            @endif
                            @if ($user->ubicacion)
                                <p class="flex items-center gap-2"><x-icon name="map-pin" class="h-4 w-4 text-gray-400" /> {{ $user->ubicacion }}</p>
                            @endif
                            @if ($user->fecha_nacimiento)
                                <p class="flex items-center gap-2"><x-icon name="calendar" class="h-4 w-4 text-gray-400" /> {{ $user->fecha_nacimiento->format('d/m/Y') }}</p>
                            @endif
                        </div>

                        @if ($user->habilidades)
                            <div class="text-left border-t border-gray-100 pt-4 mt-4">
                                <p class="text-xs font-medium text-gray-400 mb-2">HABILIDADES</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($user->habilidades as $habilidad)
                                        <span class="rounded-md bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $habilidad }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Logros: por ahora fijos, a modo de vidriera --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <p class="flex items-center gap-2 font-semibold text-[#10375d] mb-4">
                            <x-icon name="award" class="h-4 w-4" /> Logros
                        </p>
                        <div class="grid grid-cols-2 gap-3 text-center text-xs">
                            <div class="bg-gray-50 rounded-lg py-3">🎯<p class="mt-1 text-gray-600">Primera aplicación</p></div>
                            <div class="bg-gray-50 rounded-lg py-3">⭐<p class="mt-1 text-gray-600">Perfil completo</p></div>
                        </div>
                    </div>
                </div>

                {{-- ===== Columna derecha: pestañas ===== --}}
                <div>
                    <div class="flex gap-6 border-b border-gray-200 mb-6">
                        <button @click="tab = 'sobre-mi'" :class="tab === 'sobre-mi' ? 'border-[#05647a] text-[#05647a]' : 'border-transparent text-gray-500'" class="pb-3 border-b-2 text-sm font-medium">Sobre mí</button>
                        <button @click="tab = 'aplicaciones'" :class="tab === 'aplicaciones' ? 'border-[#05647a] text-[#05647a]' : 'border-transparent text-gray-500'" class="pb-3 border-b-2 text-sm font-medium">Aplicaciones</button>
                        <button @click="tab = 'guardados'" :class="tab === 'guardados' ? 'border-[#05647a] text-[#05647a]' : 'border-transparent text-gray-500'" class="pb-3 border-b-2 text-sm font-medium">Guardados</button>
                        <button @click="tab = 'cursos'" :class="tab === 'cursos' ? 'border-[#05647a] text-[#05647a]' : 'border-transparent text-gray-500'" class="pb-3 border-b-2 text-sm font-medium">Cursos</button>
                    </div>

                    {{-- --- Sobre mí: el único con datos reales --- --}}
                    <div x-show="tab === 'sobre-mi'" class="space-y-6">

                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <p class="font-semibold text-[#10375d]">Información Personal</p>
                            <p class="text-sm text-gray-500 mb-4">Cuéntanos sobre ti y tus objetivos</p>

                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PATCH')

                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                        @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                        @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                        <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                                        <input type="text" name="ubicacion" value="{{ old('ubicacion', $user->ubicacion) }}" placeholder="Ciudad, país" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                    </div>
                                </div>

                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de nacimiento</label>
                                        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $user->fecha_nacimiento?->format('Y-m-d')) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Educación</label>
                                        <input type="text" name="educacion" value="{{ old('educacion', $user->educacion) }}" placeholder="Universidad - Carrera" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sobre mí</label>
                                    <textarea name="bio" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('bio', $user->bio) }}</textarea>
                                </div>

<div x-data="{ habilidades: @js(old('habilidades', $user->habilidades ?? [])), nueva: '' }">
                                    <div class="flex flex-wrap gap-2 mb-2" x-show="habilidades.length">
                                        <template x-for="(habilidad, index) in habilidades" :key="index">
                                            <span class="inline-flex items-center gap-1.5 rounded-md bg-gray-100 px-2.5 py-1 text-xs text-gray-700">
                                                <span x-text="habilidad"></span>
                                                <button type="button" @click="habilidades.splice(index, 1)" class="text-gray-400 hover:text-red-600">
                                                    <x-icon name="x" class="h-3 w-3" />
                                                </button>
                                            </span>
                                        </template>
                                    </div>

                                    <input
                                        type="text"
                                        x-model="nueva"
                                        @keydown.enter.prevent="if (nueva.trim()) { habilidades.push(nueva.trim()); nueva = ''; }"
                                        @keydown.comma.prevent="if (nueva.trim()) { habilidades.push(nueva.trim()); nueva = ''; }"
                                        placeholder="Escribí una habilidad y presioná Enter"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                                    >

                                    <template x-for="(habilidad, index) in habilidades" :key="'campo-' + index">
                                        <input type="hidden" name="habilidades[]" :value="habilidad">
                                    </template>
                                </div>

                                <button type="submit" class="rounded-md bg-[#10375d] text-white text-sm font-medium px-5 py-2 hover:bg-[#10375d]/90">
                                    Guardar cambios
                                </button>
                            </form>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <p class="flex items-center gap-2 font-semibold text-[#10375d] mb-4">
                                <x-icon name="file-text" class="h-4 w-4" /> Currículum Vitae
                            </p>

                            <form method="POST" action="{{ route('profile.cv.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                @if ($user->cv_path)
                                    <div class="flex items-center justify-between rounded-md border border-gray-200 px-4 py-3 mb-3">
                                        <a href="{{ Storage::url($user->cv_path) }}" target="_blank" class="text-sm text-[#05647a] hover:underline">Ver CV actual</a>
                                    </div>
                                @endif

                                <label class="block border-2 border-dashed border-gray-300 rounded-lg py-8 text-center cursor-pointer hover:border-[#6db8bb]">
                                    <input type="file" name="cv" accept=".pdf,.doc,.docx" class="hidden" onchange="this.form.submit()">
                                    <x-icon name="file-text" class="h-6 w-6 text-gray-400 mx-auto mb-2" />
                                    <span class="text-sm text-gray-500">Arrastrá tu CV aquí o hacé click para seleccionar</span>
                                </label>
                                @error('cv') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </form>
                        </div>
                    </div>

                    {{-- --- Las otras tres pestañas, todavía sin datos reales --- --}}
                    <div x-show="tab === 'aplicaciones'" class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-500 text-sm">
                        Próximamente vas a poder ver acá el estado de tus postulaciones.
                    </div>
                    <div x-show="tab === 'guardados'" class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-500 text-sm">
                        Próximamente vas a poder guardar empleos para verlos acá.
                    </div>
                    <div x-show="tab === 'cursos'" class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-500 text-sm">
                        Próximamente vas a ver acá los cursos en los que te inscribiste.
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>