<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;


class HomeController extends Controller
{
    public function index()
    {
        $routes = Route::all(); // Obtén todas las rutas (ajusta esto según tu modelo y lógica de obtención de datos)
        return view('home', compact('routes'));
    }
    
}
