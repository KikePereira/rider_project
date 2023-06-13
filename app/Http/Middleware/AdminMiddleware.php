<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if ($request->user() && $request->user()->is_admin === 1) {
            // Si el usuario es administrador, permite el acceso
            return $next($request);
        }

        // Si el usuario no es administrador, redirige o devuelve una respuesta no autorizada
        return redirect('/home')->with('error', 'No tienes permisos de administrador');
    }
}
