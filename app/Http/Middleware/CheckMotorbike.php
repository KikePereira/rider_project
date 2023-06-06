<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMotorbike
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->motorbike) {
            return redirect()->route('profile')->with('error', 'Ya tienes una motocicleta registrada en tu perfil.');
        }

        return $next($request);
    }
}
