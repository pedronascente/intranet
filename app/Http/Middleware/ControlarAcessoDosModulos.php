<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class ControlarAcessoDosModulos
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

        $array_modulos = $request->session()->get('perfil')['modulos'];

        foreach ($array_modulos as $rota) {
            $arrayRotas[] =  $rota['rota'];
        }
        $url =    $request->segment(1);
        if ($url !== '/' || $url !== 'dashboard' || $url !== 'login') {
            $url = "/" . $request->segment(1);
            if ($request->segment(2)) {
                $url .= "/" . $request->segment(2);
            }
            if (!in_array($url, $arrayRotas)) {
                return redirect()
                    ->action('App\Http\Controllers\DashboardController@index');
                //->with('warning', "Você não tem permissão para acessar este Módulo.");
            }
        }
        return $next($request);
    }
}
