<?php

namespace App\Http\Middleware;

use App\Models\Modulo;
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
            $moduloDaRota = $modulo;
            $modulosDoUsuarioAutenticadoSlug = session()->get('modulosDoUsuarioAutenticadoSlug');
          
            if (in_array($moduloDaRota, $modulosDoUsuarioAutenticadoSlug)) {
                $Modulo = Modulo::with('permissoes')->where('slug','=', $moduloDaRota)->first();
                $ArrayListPermissoes = $Modulo->permissoes->pluck('nome')->toArray();
                $request->session()->put('permissoesDoModuloDaRota', $ArrayListPermissoes);
                return $next($request);
            }
        }

        return redirect()
            ->route('dashboard.index')
            ->with('error', "Você não tem permissão para acessar este Módulo.");
    }
}