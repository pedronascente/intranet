<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cartao;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Help\FormatarDataController;

class LoginController extends Controller
{
    public function showForm(Request $request)
    {
        $messagem = FormatarDataController::formatarData();
        return view('login.passo_01', ['mensagem' =>   $messagem]);
    }

    /**
     * Autenticar  usuário na aplicação.
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'O campo usuario é obrigatório!',
            'password.required' => 'O campo senha é obrigatório!',
        ]);
        $credenciais['status'] = 'on';
        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            $usuarioLogado = $request->user();
            $usuarioDB = User::with('cartao', 'perfil')->findOrFail($usuarioLogado->id);
            if ($usuarioDB->cartao) {
                $this->criarSessaoCartao($request, $usuarioDB->cartao->id);
            } else {
                $this->logout($request);
                return redirect()->back()->with('error', 'Você não possui um Cartão Token válido.');
            }
            $this->criarSessaoPerfil($request, $usuarioDB->perfil->id);

            /*
dd(
                $request->session()->all(),
                $request->user(),

            );

*/





            return redirect()
                ->action('App\Http\Controllers\TokenController@create');
        } else {
            return redirect()->back()->with('error', 'Usuário ou senha inválido.');
        }
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function recuperarSenha()
    {
        echo 'Descreva nos requisitos como será este processo de recuperação de senha';
    }

    public function recuperarCartao()
    {
        echo 'Descreva nos requisitos como será este processo de recuperação de cartao';
    }

    private function criarSessaoCartao($request, $id)
    {
        $cartao = Cartao::with('tokens')->findOrFail($id);
        $sesscaoCartao['dados'] = [
            "id" => $cartao->id,
            "status" => $cartao->status,
            "nome" => $cartao->nome,
            "qtdToken" => $cartao->qtdToken,
            "user_id" => $cartao->user_id,
        ];
        foreach ($cartao->tokens as  $token) {
            $sesscaoCartao['tokens'][] = [
                "token" => $token->token,
                "posicao" => $token->posicao
            ];
        }
        $request->session()->put('cartaoToken', $sesscaoCartao);
    }

    private function criarSessaoPerfil($request, $id)
    {
        $perfil = Perfil::with('modulos')->findOrFail($id);
        $sessaoPerfil['dados'] = [
            "id" => $perfil->id,
            "nome" => $perfil->nome,
        ];
        if ($perfil->modulos) {
            foreach ($perfil->modulos as  $modulo) {
                $sessaoPerfil['modulos'][] = [
                    "id" => $modulo->id,
                    "nome" => $modulo->nome,
                    "rota" => $modulo->rota,
                ];
            }
        }
        $request->session()->put('perfil', $sessaoPerfil);
    }
}
