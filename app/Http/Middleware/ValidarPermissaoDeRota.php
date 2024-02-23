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
        $moduloDaRota = $modulo;
        /*
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
        */



        $perfilId = auth()->user()->perfil_id; // Você pode ajustar de acordo com a forma como obtém o perfil ID
       

            // Encontrar o módulo com base no slug da rota
            $modulo = Modulo::with(['permissoes' => function ($query) use ($perfilId) {
                $query->where('perfil_id', $perfilId);
            }])
            ->where('slug', $moduloDaRota)
            ->first();

            
//dd($modulo);

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
































        return redirect()
            ->route('dashboard.index')
            ->with('error', "Você não tem permissão para acessar este Módulo.");
    }
}