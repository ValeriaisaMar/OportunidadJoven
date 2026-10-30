<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CursoController extends Controller
{
    public function index(): View
    {
        $cursos = Curso::latest()->paginate(10);

        return view('admin.cursos.index', compact('cursos'));
    }

    public function create(): View
    {
        return view('admin.cursos.form', ['curso' => new Curso()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Curso::create($this->validarDatos($request));

        return redirect()->route('admin.cursos.index')->with('status', 'Curso publicado correctamente.');
    }

    public function edit(Curso $curso): View
    {
        return view('admin.cursos.form', compact('curso'));
    }

    public function update(Request $request, Curso $curso): RedirectResponse
    {
        $curso->update($this->validarDatos($request));

        return redirect()->route('admin.cursos.index')->with('status', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso): RedirectResponse
    {
        $curso->delete();

        return redirect()->route('admin.cursos.index')->with('status', 'Curso eliminado.');
    }

    private function validarDatos(Request $request): array
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'institucion' => ['required', 'string', 'max:255'],
            'categoria' => ['nullable', 'string', 'max:100'],
            'modalidad' => ['required', Rule::in(Curso::MODALIDADES)],
            'nivel' => ['required', Rule::in(Curso::NIVELES)],
            'duracion' => ['nullable', 'string', 'max:255'],
            'horario' => ['nullable', 'string', 'max:255'],
            'fecha_inicio' => ['nullable', 'date'],
            'cupos' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'descripcion' => ['required', 'string', 'max:3000'],
            'temas' => ['nullable', 'string', 'max:2000'],
            'url_inscripcion' => ['nullable', 'url', 'max:500'],
            'contacto' => ['nullable', 'string', 'max:255', 'required_without:url_inscripcion'],
            'fecha_cierre' => ['nullable', 'date'],
        ], [
            'contacto.required_without' => 'Agrega el enlace de inscripción o un contacto (correo, teléfono o WhatsApp) para que los jóvenes puedan inscribirse.',
            'url_inscripcion.url' => 'El enlace debe empezar por https:// o http://',
        ]);

        $datos['certificado'] = $request->boolean('certificado');

        // Los temas llegan como texto, uno por línea; se guardan como lista
        $datos['temas'] = collect(preg_split('/\R/', $datos['temas'] ?? ''))
            ->map(fn ($linea) => trim($linea))
            ->filter()
            ->values()
            ->all();

        return $datos;
    }
}
