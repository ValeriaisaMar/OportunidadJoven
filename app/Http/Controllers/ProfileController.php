<?php

namespace App\Http\Controllers;

use App\Models\Empleo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        $camposParaCompletar = ['telefono', 'ubicacion', 'fecha_nacimiento', 'educacion', 'bio', 'habilidades', 'cv_path'];
        $completados = collect($camposParaCompletar)->filter(fn ($campo) => !empty($user->{$campo}))->count();
        $porcentajePerfil = (int) round((($completados + 1) / (count($camposParaCompletar) + 1)) * 100); // +1 por el nombre, que siempre está

        return view('profile.edit', [
            'user' => $user,
            'porcentajePerfil' => $porcentajePerfil,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:30',
            'ubicacion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'educacion' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
'habilidades' => 'nullable|array',
'habilidades.*' => 'string|max:50',
        ]);

        $datos['habilidades'] = isset($datos['habilidades'])
            ? array_values(array_unique(array_filter(array_map('trim', $datos['habilidades']))))
            : [];

      
        $user->fill($datos);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'perfil-actualizado');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
public function updateCv(Request $request): RedirectResponse
{
    $request->validate([
        'cv' => 'required|file|mimes:pdf,doc,docx|max:4096',
    ]);

    $user = $request->user();

    if ($user->cv_path) {
        Storage::disk('public')->delete($user->cv_path);
    }

    $user->cv_path = $request->file('cv')->store('cv', 'public');
    $user->save();

    return Redirect::route('profile.edit')->with('status', 'cv-actualizado');
}
}