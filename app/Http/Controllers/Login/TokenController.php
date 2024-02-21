<?php

namespace App\Http\Controllers\Login;

//use App\Models\Cartao;
use App\Models\User;
use App\Models\Token;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;

class TokenController extends Controller
{
    private $token;
    private $user;

    public function __construct(Token $token, User $user)
    {
        $this->token = $token;
        $this->user  = $user;
    }

    public function create()
    {
        return view('login.create_token',[
            'mensagem' => CaniveteHelp::formatarDataLogin(),
        ]);
    }

    public function store(Request $request)
    {
        if ($this->token->validarToken($request)) {
            $request->session()->put('token_validado', true);
            $this->getAcessoUsuario($request);
            return redirect('/dashboard');
        } else {
            $request->session()->forget('token_validado');
            return redirect()
                ->route("token.create")
                ->with('error', "Digite um token válido!");
        } 
    }

    private function getAcessoUsuario($request)
    {
        $usuarioAutenticado              = $request->user();

        $perfilDoUsuarioAutenticado      = $this->user->with('Perfil.modulos')->findOrFail($usuarioAutenticado->id);
       
        $modulosDoUsuarioAutenticadoId   = $perfilDoUsuarioAutenticado->perfil->modulos->pluck('id')->toArray();

        $modulosDoUsuarioAutenticadoSlug = $perfilDoUsuarioAutenticado->perfil->modulos->pluck('slug')->toArray();


      //  dd($modulosDoUsuarioAutenticadoId);
        //Extrair categorias:
        foreach ($modulosDoUsuarioAutenticadoId as $modulo_id) {
            $Modulo = Modulo::with('categoria')->find($modulo_id);
            $categoriasDoUsuarioAutenticadoNome[] = $Modulo->categoria->nome;
        }

        $request->session()->put('categoriasDoUsuarioAutenticadoNome', $categoriasDoUsuarioAutenticadoNome);
        $request->session()->put('modulosDoUsuarioAutenticadoId', $modulosDoUsuarioAutenticadoId);
        $request->session()->put('modulosDoUsuarioAutenticadoSlug', $modulosDoUsuarioAutenticadoSlug);
    }

    public function getPosicaoToken(Request $request)
    {
        $usuario      = $this->user->find($request->user()->id);
        $posicaoToken = rand(1, $usuario->qtdToken);
        return response()->json(['posicao' => $posicaoToken]);
    }
}