<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cartao;
use App\Models\Token;

class CartaoController extends Controller
{
    public function index()
    {
        $collections  =  Cartao::with('user')->orderBy('id', 'desc')->paginate(8);
        return view('cartao.index', ['collections' => $collections]);
    }

    public function create()
    {
        $users = $this->getUserSemCartao();

        if (!empty($users)) {
            return view('cartao.create', ['users' => $users]);
        } else {
            return redirect()
                ->action('App\Http\Controllers\CartaoController@index')
                ->with('warning', "Nenhum usuário sem cartão foi localizado!");
        }
    }

    public function store(Request $request)
    {
        #validar campos inputs:
        $this->validarFormulario($request);
        #buscar usuario, conforme o id passado por parametro:
        $user = User::findOrFail($request->user_id);
        #criar e associar cartão ao usuario:
        $user->cartao()->create([
            'status' => $request->status,
            'user_id' => $request->user_id,
            'nome' => "CARTAO-" . $request->user_id,
        ]);
        #retornar o cartão do usuario:
        $user = User::with('cartao')->findOrFail($request->user_id);
        $cartao = Cartao::findOrFail($user->cartao->id);
        #gerar-token:
        $this->gerarToken($cartao, 40);

        return redirect()
            ->action('App\Http\Controllers\CartaoController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        $cartao  = Cartao::with('user', 'tekens')->findOrFail($id);
        return view('cartao.show', ['cartao' => $cartao]);
    }

    public function edit($id)
    {
        $users = $this->getUserSemCartao();
        return view('cartao.edit', ['users' => $users]);
    }

    public function update(Request $request, $id)
    {
        return view('cartao.idex');
    }

    public function destroy($id)
    {
        //
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'status' => 'required',
                'user_id' => 'required',
            ],
            [
                'status.required' => 'Campo obrigatório.',
                'user_id.required' => 'Campo obrigatório.',
            ]
        );
    }
    private function gerarToken($cartao, $quantidadeToken)
    {
        for ($i = 1; $i <= $quantidadeToken; $i++) {
            $token = new Token();
            $token->token  = substr(md5(time() . rand(10, 100)), 0, 8);
            $token->posicao  = $i;
            $token->cartao()->associate($cartao)->save();
        }
    }

    private function getUserSemCartao()
    {
        $array_users = [];

        $collections = User::with('cartao')->get();
        foreach ($collections as $key => $value) {
            if ($value->cartao == null) {
                $array_users[] = [
                    'name' => $value->name,
                    'id' => $value->id,
                ];
            }
        }
        return $array_users;
    }
}
