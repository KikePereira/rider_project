<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\comment;
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
        return view('route.edit', compact('route'));
    }

    /**
     * Actualizar una ruta de moto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_location_lat' => 'required',
            'start_location_lng' => 'required',
            'end_location_lat' => 'required',
            'end_location_lng' => 'required',
        ], [
            'title.required' => 'El campo título es requerido',
            'description.required' => 'El campo descripción es requerido',
            'start_location_lat.required' => 'El campo Punto de inicio (Lat) es requerido',
            'start_location_lng.required' => 'El campo Punto de inicio (Lng) es requerido',
            'end_location_lat.required' => 'El campo Punto de llegada (Lat) es requerido',
            'end_location_lng.required' => 'El campo Punto de llegada (Lng) es requerido',
        ]);
    
        $route = Route::findOrFail($id);
        $route->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_location_lat' => $request->start_location_lat,
            'start_location_lng' => $request->start_location_lng,
            'end_location_lat' => $request->end_location_lat,
            'end_location_lng' => $request->end_location_lng,
        ]);
    
        return redirect()->route('route.show', $route->id);
    }
    

    public function destroy($id)
    {
        $route = Route::find($id);
        $route->delete();

        return redirect()->route('home');
    }

    public function confirmDelete($id)
    {
        // Obtener la ruta por su ID
        $route = Route::find($id);

        return view('route.confirm-delete', compact('route'));
    }

    public function like($id)
    {
        $route = Route::find($id);

        // Verificar si el usuario ya dio like a la ruta
        if (!$route->likes()->where('user_id', Auth::id())->exists()) {
            // Agregar el like a la ruta
            $route->likes()->attach(Auth::id());
        }

        return redirect()->back();
    }

    public function unlike($id)
    {
        $route = Route::findOrFail($id);
        $user = Auth::user();
        
        $route->likes()->detach($user->id);
        
        return back();
    }

    public function comment(Request $request, $id)
    {
        // Validar los datos del formulario de comentarios si es necesario

        // Crear un nuevo comentario
        $comment = new Comment();
        $comment->route_id = $id;
        $comment->user_id = auth()->user()->id; // Obtener el ID del usuario actualmente autenticado
        $comment->content = $request->input('content');
        $comment->save();

        // Redireccionar a la página de la ruta o realizar cualquier otra acción después de guardar el comentario

        return redirect()->route('route.show', $id);
    }

    public function comment_destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Verificar si el usuario autenticado es el propietario del comentario
        if ($comment->user_id == Auth::user()->id) {
            $comment->delete();
        }

        return redirect()->back();
    }

    public function favorite($routeId)
    {
        $user = Auth::user();
        $route = Route::find($routeId);

        $user->favoriteRoutes()->attach($route);

        return redirect()->back();
    }

    public function unfavorite($routeId)
    {
        $user = Auth::user();
        $route = Route::find($routeId);

        $user->favoriteRoutes()->detach($route);

        return redirect()->back();
    }

    public function favorites()
    {
        $favoriteRoutes = Auth::user()->favoriteRoutes;
        return view('route/favorite', compact('favoriteRoutes'));
    }

}
