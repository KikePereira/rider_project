<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'alpha'],
            'first_surname' => ['required', 'string', 'max:255', 'alpha'],
            'second_surname' => ['required', 'string', 'max:255', 'alpha','unique:users'],
            'nickname' => ['required', 'string', 'max:255'],
            'locality' => ['required', 'string', 'max:255','alpha'],
            'birthday' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d') . ',El cumpleaños debe ser al menos 18 años antes de la fecha actual.'],
            'telephone' => ['required', 'digits:9','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)/'],
            'password_confirmation' => ['required'],
        ],[
            'email.unique' => 'El correo electronico ya esta registrado.'

        ],[
            'name' => 'nombre',
            'first_surname' => 'primer apellido',
            'second_surname' => 'segundo apellido',
            'nickname' => 'nombre de usuario',
            'locality' => 'localidad',
            'birthday' => 'fecha de nacimiento',
            'telephone' => 'telefono',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmacion de contraseña',
        ]);

        $user = User::create([
            'name' => $request->name,
            'first_surname' => $request->first_surname,
            'second_surname' => $request->second_surname,
            'nickname' => $request->nickname,
            'locality' => $request->locality,
            'birthday' => $request->birthday,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
