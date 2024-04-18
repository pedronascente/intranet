<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Models\ModuloCategoria;

class AtivarDesativarModuloECategoria
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $modulo)
    {

        Modulo::AtivarDesativarModuloECategoria($modulo);

        $ModuloCategoria = ModuloCategoria::getCategoriasEseusModulos(1);

        view()->share('MenuBarraLateral', $ModuloCategoria);
        
        return $next($request);
        
    }
}
