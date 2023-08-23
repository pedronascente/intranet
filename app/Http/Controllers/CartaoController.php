<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cartao;
use App\Models\Token;

class CartaoController extends Controller
{

    /**
     * Mostrar lista dos cartões criados.
     *
     * @return void
     */
    public function index()
    {
        return view(
            'settings.cartao.index',
            [
                'collections' => Cartao::with('user')->orderBy('id', 'desc')->paginate(8),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    /**
     * Mostrar o formulário para criar um novo recurso.
     *
     * @return void
     */
    public function create()
    {
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'][8] as $item) {
                if ($item->nome == 'Criar') {
                    $users = $this->getUserSemCartao();
                    if (!empty($users)) {
                        return view('settings.cartao.create', ['users' => $users]);
                    } else {
                        return redirect()
                            ->action('App\Http\Controllers\CartaoController@index')
                            ->with('warning', "Nenhum usuário sem cartão foi localizado!");
                    }
                    break;
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\CartaoController@index');
    }

    /**
     *  Armazene um recurso recém-criado no armazenamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $user = User::findOrFail($request->user_id);
        #criar e associar cartão ao usuario:
        $user->cartao()->create([
            'status' => $request->status,
            'user_id' => $request->user_id,
            'nome' => "CARTAO-" . $request->user_id,
            'qtdToken' => (int)$request->qtdToken,
        ]);
        //retornar o cartão do usuario.
        $user = User::with('cartao')->findOrFail($request->user_id);
        $cartao = Cartao::findOrFail($user->cartao->id);
        Token::gerarToken($cartao);
        return redirect()
            ->action('App\Http\Controllers\CartaoController@index')
            ->with('status', "Registrado com sucesso!");
    }

    /**
     * Mosatrar Detalhes do cartão. 
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'][8] as $item) {
                if ($item->nome == 'Visualizar') {
                    $cartao = Cartao::with('user', 'tokens')->findOrFail($id);
                    return view('settings.cartao.show', ['cartao' => $cartao]);
                    break;
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\CartaoController@index');
    }

    /**
     * Mostrar formulario para edição.
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'][8] as $item) {
                if ($item->nome == 'Editar') {
                    $cartao = Cartao::with('user')->findOrFail($id);
                    return view('settings.cartao.edit', ['cartao' => $cartao]);
                    break;
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\CartaoController@index');
    }
    /**
     * Atualizar cartão.
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $cartao = Cartao::with('user', 'tokens')->findOrFail($id);
        $cartao->status =  $request->status;
        $cartao->qtdToken =  $request->qtdToken;
        $cartao->update();
        if (isset($request->resetToken) && $request->resetToken == 'on') {
            Token::gerarToken($cartao);
        }
        return redirect()
            ->action('App\Http\Controllers\CartaoController@show', $cartao->id)
            ->with('status', "Atualizado com sucesso!");
    }

    /**
     * Excluir cartão.
     *
     * @param [Integer] $id
     * @return void
     */
    public function destroy($id)
    {
        $cartao = Cartao::findOrfail($id);
        $cartao->delete();
        return redirect()
            ->action('App\Http\Controllers\CartaoController@index')
            ->with('status', "Excluido com sucesso!");
    }

    public function registrarCartaoUsuario($usuario)
    {
        $user = User::findOrFail($usuario);
        $user->cartao()->create([
            'status' => 'on',
            'user_id' => $usuario,
            'nome' => "CARTAO-" . $usuario,
            'qtdToken' => 40,
        ]);

        $cartao = Cartao::findOrFail($user->cartao->id);
        Token::gerarToken($cartao);
        return redirect()
            ->action('App\Http\Controllers\UserController@show', $usuario)
            ->with('status', "Cartão Registrado com sucesso!");
    }

    /**
     * Válidar formulário.
     *
     * @param Request $request
     * @return void
     */
    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'status' => 'required',
                'user_id' => 'required',
                'qtdToken' => 'required',
            ],
            [
                'status.required' => 'Campo obrigatório.',
                'user_id.required' => 'Campo obrigatório.',
                'qtdToken.required' => 'Campo obrigatório.',
            ]
        );
    }

    /**
     * Retornar lista dos usuários sem cartão.
     *
     * @return void
     */
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

    /**
     * Api
     *
     * @param Request $request
     * @return void
     */
    public function getPosicaoDoTokenNoCartao(Request $request)
    {
        $qtd = Token::getCartaoDoUsuarioLogado($request);
        $posicaoDoToken = rand(1, $qtd->qtdToken);
        return $posicaoDoToken;
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][8]) ? session()->get('perfil')['permissoes'][8]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }
}
