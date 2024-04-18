<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Models\ModuloCategoria;
use Illuminate\Support\Facades\View;
class PermissaoDeAcessoDoUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $moduloVindoDaRota)
    {
       $this->getAcessoUsuario($request, $moduloVindoDaRota);
        // Continua com o próximo middleware na cadeia
        return $next($request);
    }

    private function getAcessoUsuario($request, $moduloVindoDaRota)
    {
        $perfilDoUsuarioAutenticado         = null;
        $categoriasDoUsuarioAutenticadoNome = [];
        $modulosDoUsuarioAutenticadoId      = [];
        $modulosDoUsuarioAutenticadoSlug    = [];

        // Excluir uma sessão usando o método forget()
        $request->session()->forget('perfilDoUsuarioAutenticado');
        $request->session()->forget('categoriasDoUsuarioAutenticadoNome');
        $request->session()->forget('modulosDoUsuarioAutenticadoId');
        $request->session()->forget('modulosDoUsuarioAutenticadoSlug');
        $request->session()->forget('permissoesDoModuloDaRota');

        $usuario_logado = auth()->user();
        $usuario = User::with('perfil')->find($usuario_logado->id);

        $perfilDoUsuarioAutenticado      = $usuario->perfil;
        $modulosDoUsuarioAutenticadoId   = $usuario->perfil->modulos->pluck('id')->toArray();
        $modulosDoUsuarioAutenticadoSlug = $usuario->perfil->modulos->pluck('slug')->toArray();

        if ($modulosDoUsuarioAutenticadoId) {
            //Extrair categorias:
            foreach ($modulosDoUsuarioAutenticadoId as $modulo_id) {
                $Modulo = Modulo::with('categoria')->find($modulo_id);
                $categoriasDoUsuarioAutenticadoNome[] = $Modulo->categoria->nome;
            }
        }

        $permissoesDoPerfil = $this->getPermissoesDoModulo($perfilDoUsuarioAutenticado, $moduloVindoDaRota, $request);

        $request->session()->put('perfilDoUsuarioAutenticado', $perfilDoUsuarioAutenticado);
        $request->session()->put('categoriasDoUsuarioAutenticadoNome', $categoriasDoUsuarioAutenticadoNome);
        $request->session()->put('modulosDoUsuarioAutenticadoId', $modulosDoUsuarioAutenticadoId);
        $request->session()->put('modulosDoUsuarioAutenticadoSlug', $modulosDoUsuarioAutenticadoSlug);
        $request->session()->put('permissoesDoModuloDaRota', $permissoesDoPerfil);

        View::share('arrayListPermissoesDoModuloDaRota', $permissoesDoPerfil);

        $this->ativarMenuSelecionadoBarraLateral($moduloVindoDaRota);
    }


    private function  getPermissoesDoModulo($perfil,$moduloVindoDaRota)
    {
        $perfil_id = $perfil->id;
        $modulo = Modulo::with(['permissoes' => function ($query) use ($perfil_id) {
            $query->where('perfil_id', $perfil_id);
        }])->where('slug', $moduloVindoDaRota)->first();

        if($modulo){
            $permissoes = $modulo->permissoes->pluck('nome')->toArray();
        }else{
            $permissoes = [];
        }
        return $permissoes;
    }

    private function ativarMenuSelecionadoBarraLateral($modulo)
    {
        Modulo::AtivarDesativarModuloECategoria($modulo);
        $ModuloCategoria = ModuloCategoria::getCategoriasEseusModulos(1);
        view()->share('MenuBarraLateral', $ModuloCategoria);
    }
}