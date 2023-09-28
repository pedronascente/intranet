<?php

namespace App\Http\Controllers\Login;

//use App\Models\Cartao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\FormatarDataController;
use App\Models\Token;

class TokenController extends Controller
{
    private $actionCreate;

    public function __construct()
    {
        $this->actionCreate = 'App\Http\Controllers\Login\TokenController@create';
    }

    /**
     * Mostra um formulario para criar um novo recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $qtd = Token::getCartaoDoUsuarioLogado($request);
        $posicaoDoToken = rand(1, $qtd->qtdToken);
        return view('login.passo_02', [
            'mensagem' => FormatarDataController::formatarData(),
            'posicaoDoToken' => $posicaoDoToken
        ]);
    }

    /**
     *  Armazene um recurso recém-criado no armazenamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Token::validarToken($request)) {
            $request->session()->put('cartaoToken', true);
            return redirect('/dashboard');
        } else {
            $request->session()->forget('cartaoToken');
            return redirect()
                ->action($this->actionCreate)
                ->with('error', "Digite um token válido!");
        }
    }
}
