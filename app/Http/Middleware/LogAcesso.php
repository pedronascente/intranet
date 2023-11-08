<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogAcesso
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
        $ip = $request->server->get('REMOTE_ADDR');
        $route = $request->getRequestUri();

        \App\Models\LogAcesso::create(['log' => "Ip: {$ip} - requisitou rota : {$route}"]);

        //return response('chegamos aqui!');
        return $next($request);
    }
}
