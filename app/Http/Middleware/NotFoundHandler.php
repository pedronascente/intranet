<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotFoundHandler
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
        $response = $next($request);

        // Verifica se a resposta tem um status de erro 404
        if ($response->status() == 404) {
            // Personalize aqui como desejar, pode ser uma página específica, redirecionamento, etc.
            return response()->view('errors.custom404', [], 404);
        }

        return $response;
    }
}
