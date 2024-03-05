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
        // Se o usuário não estiver logado, redirecionar para a página de login
        if (!auth()->check()) {
            return redirect()->route('login.form');
        }

        $perfilId = auth()->user()->perfil_id; 



        // Encontrar o módulo com base no slug da rota
        $modulo = Modulo::with(['permissoes' => function ($query) use ($perfilId) {
            $query->where('perfil_id', $perfilId);
        }])->where('slug', $modulo)->first();

        // Verifica se o módulo foi encontrado
        if ($modulo) {
            $request->session()->forget('permissoesDoModuloDaRota');
            // Obtém as permissões associadas ao perfil específico do usuário
            $permissoesDoPerfil = $modulo->permissoes->pluck('nome')->toArray();

            // Define as permissões na sessão
            $request->session()->put('permissoesDoModuloDaRota', $permissoesDoPerfil);
        } else {
            // Caso o módulo não seja encontrado, você pode lidar com isso aqui
            // Por exemplo, redirecionar ou retornar uma resposta adequada
        }

        // Continua com o próximo middleware na cadeia
        return $next($request);
    }

}