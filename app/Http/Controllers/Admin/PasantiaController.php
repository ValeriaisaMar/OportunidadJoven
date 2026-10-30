<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasantia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PasantiaController extends Controller
{
    public const MODALIDADES = ['Presencial', 'Remoto', 'Híbrido'];

    public function index(): View
    {
        $pasantias = Pasantia::latest()->paginate(10);

        return view('admin.pasantias.index', compact('pasantias'));
    }

    public function create(): View
    {
        return view('admin.pasantias.form', ['pasantia' => new Pasantia()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Pasantia::create($this->validarDatos($request));

        return redirect()->route('admin.pasantias.index')->with('status', 'Pasantía publicada correctamente.');
    }

    public function edit(Pasantia $pasantia): View
    {
        return view('admin.pasantias.form', compact('pasantia'));
    }

    public function update(Request $request, Pasantia $pasantia): RedirectResponse
    {
        $pasantia->update($this->validarDatos($request));

        return redirect()->route('admin.pasantias.index')->with('status', 'Pasantía actualizada correctamente.');
    }

    public function destroy(Pasantia $pasantia): RedirectResponse
    {
        $pasantia->delete();

        return redirect()->route('admin.pasantias.index')->with('status', 'Pasantía eliminada.');
    }

    private function validarDatos(Request $request): array
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'empresa' => ['required', 'string', 'max:255'],
            'ubicacion' => ['required', 'string', 'max:255'],
            'tipo' => ['required', Rule::in(Pasantia::TIPOS)],
            'modalidad' => ['required', Rule::in(self::MODALIDADES)],
            'duracion_meses' => ['nullable', 'integer', 'between:1,36'],
            'horario' => ['nullable', 'string', 'max:255'],
            'estipendio' => ['nullable', 'string', 'max:255'],
            'fecha_inicio' => ['nullable', 'date'],
            'descripcion' => ['required', 'string', 'max:3000'],
            'requisitos' => ['nullable', 'string', 'max:2000'],
            'beneficios' => ['nullable', 'string', 'max:2000'],
            'url_postulacion' => ['nullable', 'url', 'max:500'],
            'contacto' => ['nullable', 'string', 'max:255', 'required_without:url_postulacion'],
            'fecha_cierre' => ['nullable', 'date'],
        ], [
            'contacto.required_without' => 'Agrega el enlace de la convocatoria o un contacto (correo, teléfono o WhatsApp) para que los jóvenes puedan postularse.',
            'url_postulacion.url' => 'El enlace debe empezar por https:// o http://',
        ]);

        $datos['requisitos'] = $this->aLista($datos['requisitos'] ?? null);
        $datos['beneficios'] = $this->aLista($datos['beneficios'] ?? null);

        return $datos;
    }

    /** Convierte un texto con un elemento por línea en una lista. */
    private function aLista(?string $texto): array
    {
        return collect(preg_split('/\R/', $texto ?? ''))
            ->map(fn ($linea) => trim($linea))
            ->filter()
            ->values()
            ->all();
    }
}
