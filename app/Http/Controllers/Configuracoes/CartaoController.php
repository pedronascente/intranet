<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\User;
use App\Models\Token;
use App\Models\Cartao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class CartaoController extends Controller
{
    private $modulo;
    private $paginate;
    private $qtdToken;
    private $actionIndex;
    private $actionShow;
    private $actionUserShow;

    public function __construct()
    {
        $this->modulo = 8;
        $this->paginate = 10;
        $this->qtdToken = 40;
        $this->actionIndex = 'App\Http\Controllers\Configuracoes\CartaoController@index';
        $this->actionShow = 'App\Http\Controllers\Configuracoes\CartaoController@show';
        $this->actionUserShow = 'App\Http\Controllers\Configuracoes\UserController@show';
    }

    public function index()
    {
        return view('configuracoes.cartao.index', [
            'collections' => Cartao::with('user')->orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('configuracoes.cartao.create', ['users' => $this->getUserSemCartao()]);
        } else {
            return redirect()->action($this->actionIndex);
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $user = User::findOrFail($request->user_id);

        $user->cartao()->create([
            'status' => $request->status,
            'user_id' => $request->user_id,
            'nome' => "CARTAO-" . $request->user_id,
            'qtdToken' => (int)$request->qtdToken,
        ]);

        $user = User::with('cartao')->findOrFail($request->user_id);
        $cartao = Cartao::findOrFail($user->cartao->id);
        Token::gerarToken($cartao);

        return redirect()->action($this->actionIndex)->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        foreach (PermissaoHelp::getPermissoes($this->modulo) as $permissao) {
            if ($permissao->nome == 'Visualizar') {
                return view('configuracoes.cartao.show', ['cartao' => Cartao::with('user', 'tokens')->findOrFail($id)]);
            }
        }

        return redirect()->action($this->actionIndex);
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('configuracoes.cartao.edit', ['cartao' => Cartao::with('user')->findOrFail($id)]);
        } else {
            return redirect()->action($this->actionIndex);
        }
    }

    public function update(Request $request, $id)
    {
        $cartao = Cartao::with('user', 'tokens')->findOrFail($id);
        $cartao->status = $request->status;
        $cartao->qtdToken = $request->qtdToken;
        $cartao->update();

        if (isset($request->resetToken) && $request->resetToken == 'on') {
            Token::gerarToken($cartao);
        }

        return redirect()->action($this->actionShow, $cartao->id)->with('status', "Atualizado com sucesso!");
    }

    public function destroy($id)
    {
        $cartao = Cartao::findOrFail($id);
        $cartao->delete();

        return redirect()->action($this->actionIndex)->with('status', "Excluido com sucesso!");
    }

    public function registrarCartaoUsuario($usuario)
    {
        $user = User::findOrFail($usuario);
        $user->cartao()->create([
            'status' => 'on',
            'user_id' => $usuario,
            'nome' => "2FA-" . $usuario,
            'qtdToken' => $this->qtdToken,
        ]);

        $cartao = Cartao::findOrFail($user->cartao->id);
        Token::gerarToken($cartao);

        return redirect()->action($this->actionUserShow, $usuario)->with('status', "2FA Registrado com sucesso!");
    }

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

    public function getPosicaoDoTokenNoCartao(Request $request)
    {
        $qtd = Token::getCartaoDoUsuarioLogado($request);
        $posicaoDoToken = rand(1, $qtd->qtdToken);

        return response()->json(['posicao' => $posicaoDoToken]);
    }
}
