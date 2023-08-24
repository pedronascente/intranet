<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarPermissao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        /*

        $permissao = $request->session()->get('perfil');

        if (isset($permissao['permissao'][1])) {
            foreach (session()->get('perfil')['permissoes'][1] as $item) {
                if ($item->nome == 'Criar' || $item->nome == 'Editar') {
                    return redirect()
                        ->action('App\Http\Controllers\DashboardController@index');
                    break;
                }
            }
        } else {
            return redirect()
                ->action('App\Http\Controllers\DashboardController@index');
        }
*/

        return $next($request);
    }
}
