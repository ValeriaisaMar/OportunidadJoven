<?php

namespace App\Http\Controllers;

use App\Models\Pasantia;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasantiaController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = trim($request->string('q')->toString());
        $ubicacion = $request->string('ubicacion')->toString();
        $duracion = $request->string('duracion')->toString();
        $tipo = in_array($request->input('tipo'), Pasantia::TIPOS, true) ? $request->input('tipo') : null;

        $rangos = ['3-4' => [3, 4], '5-6' => [5, 6], '7-24' => [7, 24]];

        $pasantias = Pasantia::vigentes()
            ->when($tipo, fn ($query) => $query->where('tipo', $tipo))
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('titulo', 'like', '%' . $busqueda . '%')
                      ->orWhere('empresa', 'like', '%' . $busqueda . '%');
                });
            })
            ->when($ubicacion !== '' && $ubicacion !== 'Todas las ubicaciones', fn ($query) => $query->where('ubicacion', $ubicacion))
            ->when(isset($rangos[$duracion]), fn ($query) => $query->whereBetween('duracion_meses', $rangos[$duracion]))
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $conteos = Pasantia::vigentes()
            ->selectRaw('tipo, count(*) as total')
            ->groupBy('tipo')
            ->pluck('total', 'tipo');

        return view('pasantias.index', [
            'pasantias' => $pasantias,
            'ubicaciones' => Pasantia::vigentes()->distinct()->orderBy('ubicacion')->pluck('ubicacion'),
            'tipos' => Pasantia::TIPOS,
            'tipoActivo' => $tipo,
            'conteos' => $conteos,
            'total' => $conteos->sum(),
            'duraciones' => ['3-4' => '3 a 4 meses', '5-6' => '5 a 6 meses', '7-24' => '7 meses o más'],
        ]);
    }
}
