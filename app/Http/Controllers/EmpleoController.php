<?php

namespace App\Http\Controllers;

use App\Models\Empleo;
use Illuminate\Http\Request;

class EmpleoController extends Controller
{
    public function index(Request $request)
    {
        $empleos = Empleo::query()
        ->where(function ($query) {
    $query->whereNull('fecha_cierre')->orWhereDate('fecha_cierre', '>=', today());
})
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('titulo', 'like', '%' . $request->q . '%')
                      ->orWhere('empresa', 'like', '%' . $request->q . '%');
                });
            })
            ->when($request->filled('ubicacion') && $request->ubicacion !== 'Todas las ubicaciones', function ($query) use ($request) {
                $query->where('ubicacion', $request->ubicacion);
            })
            ->when($request->filled('jornada') && $request->jornada !== 'Todos los tipos', function ($query) use ($request) {
                $query->where('jornada', $request->jornada);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $ubicaciones = Empleo::distinct()->pluck('ubicacion');
        $jornadas = ['Tiempo completo', 'Medio tiempo', 'Por proyecto'];

        return view('empleos.index', compact('empleos', 'ubicaciones', 'jornadas'));
    }
}