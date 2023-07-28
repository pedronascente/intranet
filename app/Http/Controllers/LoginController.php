<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cartao;
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
            $CartaoTokenDoUsuario = User::with('cartao')->find($usuarioLogado->id);
            if ($CartaoTokenDoUsuario->cartao) {
                $cartaoToken = Cartao::with('tokens')->findOrFail($CartaoTokenDoUsuario->cartao->id);
                $request->session()->put('cartaoToken', $cartaoToken);
            } else {
                $this->logout($request);
                return redirect()->back()->with('error', 'Você não possui um Cartão Token válido.');
            }
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
}
