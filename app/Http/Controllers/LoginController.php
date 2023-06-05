<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $messagem = $this->formatarData();

        return view('login.index', ['mensagem' => $messagem]);
    }
    private function formatarData()
    {
        $horaAtual = now()->format('H');

        if ($horaAtual >= 19) {
            $ret = 'Boa Noite, para iniciar insira seus dados.';
        } else if ($horaAtual <= 18 &&  $horaAtual >= 12) {
            $ret = 'Boa Tarde, para iniciar insira seus dados.';
        } else {
            $ret = 'Bom Dia, para iniciar insira seus dados.';
        }
        return $ret;
    }
}
