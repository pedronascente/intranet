<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private  $messagem;

    public function __construct()
    {
        $this->messagem = $this->formatarData();
    }

    public function showForm()
    {
        return view('login.passo_01', ['mensagem' =>   $this->messagem]);
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

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended(route('token'));
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

    private function formatarData()
    {
        $horaAtual = now()->format('H');

        if ($horaAtual >= 19) {
            $ret = 'Boa Noite';
        } else if ($horaAtual <= 18 &&  $horaAtual >= 12) {
            $ret = 'Boa Tarde';
        } else {
            $ret = 'Bom Dia';
        }
        return $ret;
    }

    public function showFormToken()
    {
        $numero_rand = rand(1, 40);
        return view('login.passo_02', [
            'mensagem' => $this->messagem,
            'numero_rand' => $numero_rand
        ]);
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
