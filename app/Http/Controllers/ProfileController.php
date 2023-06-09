<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;



class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile/index', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::find($id);

        // Verificar si el usuario tiene una motorbike asociada y eliminarla si es necesario
        if ($user->motorbike) {
            $user->motorbike->delete();
        }

        // Eliminar el usuario
        $user->delete();

        return redirect()->route('login');
    }

    public function viewProfileRoutes($userId)
    {
        $user = User::findOrFail($userId);
    
        if (Auth::user()->friends->contains('id', $user->id)) {
            $routes = $user->routes()
                ->where(function ($query) {
                    $query->where('visibility', 'public')
                        ->orWhere('visibility', 'friends');
                })
                ->orderByDesc('created_at')
                ->paginate(5);
        } else {
            $routes = $user->routes()
                ->where('visibility', 'public')
                ->orderByDesc('created_at')
                ->paginate(5);
        }
    
        return view('profile.user_routes', compact('user', 'routes'));
    }
    
    public function viewProfileRoutes_likes($userId)
    {
        $user = User::findOrFail($userId);

        if (Auth::user()->friends->contains('id', $user->id)) {
            $routes = $user->routes()
                ->where(function ($query) {
                    $query->where('visibility', 'public')
                        ->orWhere('visibility', 'friends');
                })
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->paginate(5);
        } else {
            $routes = $user->routes()
                ->where('visibility', 'public')
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->paginate(5);
        }

        return view('profile.user_routes', compact('user', 'routes'));
    }

    public function viewProfileRoutes_comments($userId)
    {
        $user = User::findOrFail($userId);

        if (Auth::user()->friends->contains('id', $user->id)) {
            $routes = $user->routes()
                ->where(function ($query) {
                    $query->where('visibility', 'public')
                        ->orWhere('visibility', 'friends');
                })
                ->withCount('comments')
                ->orderByDesc('comments_count')
                ->paginate(5);
        } else {
            $routes = $user->routes()
                ->where('visibility', 'public')
                ->withCount('comments')
                ->orderByDesc('comments_count')
                ->paginate(5);
        }

        return view('profile.user_routes', compact('user', 'routes'));
    }

    public function confirmDelete()
    {
        return view('profile.confirm-delete');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.update', compact('user'));
    }

    public function update(Request $request)
    {
        // Validar los datos ingresados en el formulario
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'alpha'],
            'first_surname' => ['required', 'string', 'max:255', 'alpha'],
            'second_surname' => ['required', 'string', 'max:255', 'alpha'],
            'nickname' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'locality' => ['required', 'string', 'max:255','alpha'],
            'birthday' => ['required', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d') . ',El cumpleaños debe ser al menos 18 años antes de la fecha actual.'],
            'telephone' => ['required', 'digits:9', Rule::unique('users')->ignore(Auth::id())],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
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
        ]);

        // Obtener el usuario actualmente autenticado
        $user = auth()->user();

        // Actualizar los datos del perfil con los valores ingresados
        $user->name = $request->name;
        $user->first_surname = $request->first_surname;
        $user->second_surname = $request->second_surname;
        $user->nickname = $request->nickname;
        $user->locality = $request->locality;
        $user->birthday = $request->birthday;
        $user->telephone = $request->telephone;
        $user->email = $request->email;

        // Guardar los cambios en la base de datos
        $user->save();

        // Redirigir al perfil con un mensaje de éxito
        return redirect()->route('profile');
    }

    public function user_profile($id)
    {
        $user = User::findOrFail($id);

        return view('profile.show', compact('user'));
    }

    public function loadRoutes()
    {
        $user = Auth::user();
        $routes = $user->routes()
                    ->latest()
                    ->paginate(5);

        return view('profile/routes', compact('routes'));
    }

    public function loadRoutes_likes()
    {
        $user = Auth::user();
        $routes = $user->routes()
                    ->withCount('likes')
                    ->orderByDesc('likes_count')
                    ->paginate(5);

        return view('profile/routes', compact('routes'));
    }

    public function loadRoutes_comments()
    {
        $user = Auth::user();
        $routes = $user->routes()
                    ->withCount('comments')
                    ->orderByDesc('comments_count')
                    ->paginate(5);

        return view('profile/routes', compact('routes'));
    }

    public function loadRoutes_privates()
{
    $user = Auth::user();
    $routes = $user->routes()
                ->where('visibility', 'private') // Agrega esta condición para obtener solo las rutas privadas
                ->latest()
                ->paginate(5);

    return view('profile/routes', compact('routes'));
}


}
