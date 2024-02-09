<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidarPermissaoDeRota
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
        if(session()->get('modulosDoUsuarioAutenticadoSlug')){
            $moduloDaRota                    = $modulo;
            $modulosDoUsuarioAutenticadoSlug = session()->get('modulosDoUsuarioAutenticadoSlug');
            
            if (in_array($moduloDaRota, $modulosDoUsuarioAutenticadoSlug)) {
                return $next($request);
            }
        }

        return redirect()
            ->route('dashboard.index')
            ->with('error', "Você não tem permissão para acessar este Módulo.");
    }
}