<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RouteController extends Controller
{
    /**
     * Mostrar la lista de rutas de motos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::all();
        return view('routes.index', compact('routes'));
    }

    /**
     * Mostrar el formulario para crear una nueva ruta de moto.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('route.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_location_lat' => 'required',
            'start_location_lng' => 'required',
            'end_location_lat' => 'required',
            'end_location_lng' => 'required',
        ],[

        ],[
            'title' => 'titulo',
            'description' => 'descripcion',
            'start_location_lat' => 'Punto de inicio',
            'start_location_lng' => 'Punto de inicio',
            'end_location_lat' => 'Punto de llegada',
            'end_location_lng' => 'Punto de llegada',

        ]);

        $route = new Route();
        $route->user_id = Auth::user()->id;
        $route->title = $request->title;
        $route->description = $request->description;
        $route->start_location_lat = $request->start_location_lat;
        $route->start_location_lng = $request->start_location_lng;
        $route->end_location_lat = $request->end_location_lat;
        $route->end_location_lng = $request->end_location_lng;

        $route->save();

        return redirect()->route('home');
    }

    public function show($id)
    {
        $route = Route::findOrFail($id);

        return view('route.show', compact('route'));
    }

    /**
     * Mostrar el formulario para editar una ruta de moto.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        return view('routes.edit', compact('route'));
    }

    /**
     * Actualizar una ruta de moto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'start_location' => 'required',
            'end_location' => 'required',
            'polyline' => 'required',
        ]);

        $route->update($validatedData);

        return redirect()->route('routes.index')->with('success', 'La ruta de moto ha sido actualizada correctamente.');
    }

    /**
     * Eliminar una ruta de moto de la base de datos.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('routes.index')->with('success', 'La ruta de moto ha sido eliminada correctamente.');
    }
}
