<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    private  $messagem;

    public function __construct()
    {
        $this->messagem = $this->formatarData();
    }

    public function index()
    {
        return view('login.index', ['mensagem' =>   $this->messagem]);
    }

    public function create_token()
    {
        return view('login.authtoken', ['mensagem' => $this->messagem]);
    }

    public function recuperarSenha()
    {
        echo 'Descreva nos requisitos como será este processo de recuperação de senha';
    }

    public function recuperarCartao()
    {
        echo 'Descreva nos requisitos como será este processo de recuperação de cartao';
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
}
