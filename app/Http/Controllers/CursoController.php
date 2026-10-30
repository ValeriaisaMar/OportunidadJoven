<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CursoController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = trim($request->string('q')->toString());
        $categoria = $request->string('categoria')->toString();
        $modalidad = $request->string('modalidad')->toString();
        $vista = in_array($request->input('vista'), ['proximos', 'guardados'], true)
            ? $request->input('vista')
            : 'todos';

        // Ids de los cursos que guardó la persona (vacío si no ha iniciado sesión)
        $guardadosIds = $request->user()
            ? DB::table('curso_user')->where('user_id', $request->user()->id)->pluck('curso_id')
            : collect();

        $cursos = Curso::vigentes()
            ->when($vista === 'proximos', fn ($query) => $query->whereDate('fecha_inicio', '>=', today()))
            ->when($vista === 'guardados', fn ($query) => $query->whereIn('id', $guardadosIds->all()))
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('titulo', 'like', '%' . $busqueda . '%')
                      ->orWhere('institucion', 'like', '%' . $busqueda . '%');
                });
            })
            ->when($categoria !== '', fn ($query) => $query->where('categoria', $categoria))
            ->when(in_array($modalidad, Curso::MODALIDADES, true), fn ($query) => $query->where('modalidad', $modalidad))
            ->when(
                $vista === 'proximos',
                fn ($query) => $query->orderBy('fecha_inicio'),
                fn ($query) => $query->latest()
            )
            ->paginate(6)
            ->withQueryString();

        return view('cursos.index', [
            'cursos' => $cursos,
            'categorias' => Curso::vigentes()->whereNotNull('categoria')->distinct()->orderBy('categoria')->pluck('categoria'),
            'modalidades' => Curso::MODALIDADES,
            'vista' => $vista,
            'guardadosIds' => $guardadosIds,
        ]);
    }

    /** Guarda o quita de guardados un curso para la persona con sesión iniciada. */
    public function guardar(Request $request, Curso $curso): RedirectResponse
    {
        $curso->guardadoPor()->toggle($request->user()->id);

        return back();
    }
}
