<?php

namespace App\Http\Controllers\Login;

//use App\Models\Cartao;
use App\Models\User;
use App\Models\Token;
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
            return redirect('/dashboard');
        } else {
            $request->session()->forget('token_validado');
            return redirect()->route("token.create")->with('error', "Digite um token válido!");
        } 
    }

    public function getPosicaoToken(Request $request)
    {
        $usuario = $this->user->find($request->user()->id);
        $posicaoToken = rand(1, $usuario->qtdToken);
        return response()->json(['posicao' => $posicaoToken]);
    }
}  