<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;


class HomeController extends Controller
{
    public function index()
    {
        $routes = Route::paginate(5); // Obtén las rutas paginadas de 5 en 5
        return view('home', compact('routes'));
    }
    
    public function search(Request $request)
    {
        $user = $request->input('nickname');

        // Obtén las rutas filtradas por el nombre de usuario
        $routes = Route::whereHas('user', function ($query) use ($user) {
            $query->where('nickname', 'like', '%' . $user . '%');
        })->paginate(5);

        return view('home', compact('routes'));
    }
}
