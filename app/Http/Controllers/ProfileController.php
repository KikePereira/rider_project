<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile/index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        // Lógica para actualizar el perfil del usuario
        // ...

        return redirect()->route('profile')->with('success', 'Perfil actualizado exitosamente.');
    }
}
