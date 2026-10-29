<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmpleoController extends Controller
{
    public const MODALIDADES = ['Presencial', 'Remoto', 'Híbrido'];
    public const JORNADAS = ['Tiempo completo', 'Medio tiempo', 'Por proyecto'];
    public const EXPERIENCIAS = ['Sin experiencia', 'Hasta 1 año', '1 a 2 años', 'Más de 2 años'];

    public function index(): View
    {
        $empleos = Empleo::latest()->paginate(10);

        return view('admin.empleos.index', compact('empleos'));
    }

    public function create(): View
    {
        return view('admin.empleos.form', ['empleo' => new Empleo()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Empleo::create($this->validarDatos($request));

        return redirect()->route('admin.empleos.index')->with('status', 'Empleo publicado correctamente.');
    }

    public function edit(Empleo $empleo): View
    {
        return view('admin.empleos.form', compact('empleo'));
    }

    public function update(Request $request, Empleo $empleo): RedirectResponse
    {
        $empleo->update($this->validarDatos($request));

        return redirect()->route('admin.empleos.index')->with('status', 'Empleo actualizado correctamente.');
    }

    public function destroy(Empleo $empleo): RedirectResponse
    {
        $empleo->delete();

        return redirect()->route('admin.empleos.index')->with('status', 'Empleo eliminado.');
    }

    private function validarDatos(Request $request): array
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'empresa' => ['required', 'string', 'max:255'],
            'ubicacion' => ['required', 'string', 'max:255'],
            'modalidad' => ['required', Rule::in(self::MODALIDADES)],
            'jornada' => ['required', Rule::in(self::JORNADAS)],
            'experiencia' => ['required', Rule::in(self::EXPERIENCIAS)],
            'salario' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:3000'],
            'requisitos' => ['nullable', 'string', 'max:2000'],
            'url_postulacion' => ['nullable', 'url', 'max:500'],
            'contacto' => ['nullable', 'string', 'max:255', 'required_without:url_postulacion'],
            'fecha_cierre' => ['nullable', 'date'],
        ], [
            'contacto.required_without' => 'Agrega el enlace de la convocatoria o un contacto (correo, teléfono o WhatsApp) para que los jóvenes puedan aplicar.',
            'url_postulacion.url' => 'El enlace debe empezar por https:// o http://',
        ]);

        // El formulario manda los requisitos como texto, uno por línea; se guardan como lista
        $datos['requisitos'] = collect(preg_split('/\R/', $datos['requisitos'] ?? ''))
            ->map(fn ($linea) => trim($linea))
            ->filter()
            ->values()
            ->all();

        return $datos;
    }
}
