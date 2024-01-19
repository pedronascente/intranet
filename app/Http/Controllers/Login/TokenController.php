<?php

namespace App\Http\Controllers\Login;

//use App\Models\Cartao;
use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\FormatarDataController;

class TokenController extends Controller
{
    private $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function create(Request $request)
    {
        $usuariro       = User::find($request->user()->id);
        $posicaoDoToken = rand(1, $usuariro->qtdToken);
        return view(
            'login.create_token',
            [
                'mensagem'       => FormatarDataController::formatarData(),
                'posicaoDoToken' => $posicaoDoToken
            ]
        );
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
        $usuarioLogado = $request->user();
        $usuario       = User::with('Perfil')->findOrFail($usuarioLogado->id);
        $request->session()->put('usuarioAutenticado', $usuario);
    }
}
