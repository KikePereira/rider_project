<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Motorbike;


class MotorbikeController extends Controller
{
    public function create()
    {
        return view('motorbike.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'registration_number' => ['required', 'regex:/^\d{4}[A-Za-z]{3}$/'],
            'adquired_at' => 'required',
        ],[
            'registration_number.unique' => 'Esa matricula ya esta registrado.'

        ],[
            'brand' => 'marca',
            'model' => 'modelo',
            'year' => 'año',
            'registration_number' => 'matricula',
            'adquired_at' => 'fecha de adquisicion',
        ]);

        // Crear una nueva instancia de Motorbike con los datos validados
        $motorbike = new Motorbike();
        $motorbike->user_id = Auth::user()->id;
        $motorbike->brand = $request->brand;
        $motorbike->model = $request->model;
        $motorbike->year = $request->year;
        $motorbike->registration_number = $request->registration_number;
        $motorbike->adquired_at = $request->adquired_at;


        // Guardar la motocicleta en la base de datos
        $motorbike->save();

        // Redirigir a la página de visualización de la motocicleta recién creada
        return redirect()->route('profile');
    }

    public function destroy()
{
    // Obtener el usuario autenticado
    $user = Auth::user();

    // Verificar si el usuario tiene una motocicleta
    if ($user->motorbike) {
        // Eliminar la motocicleta del usuario
        $user->motorbike->delete();

        // Redireccionar a la página de perfil con un mensaje de éxito
        return redirect()->route('profile')->with('success', 'Motocicleta eliminada correctamente.');
    }

    // Si el usuario no tiene una motocicleta, redireccionar a la página de perfil con un mensaje de error
    return redirect()->route('profile')->with('error', 'No se encontró una motocicleta para eliminar.');
}

public function confirmDelete(Motorbike $motorbike)
{
    return view('motorbike.confirm-delete', compact('motorbike'));
}

}
