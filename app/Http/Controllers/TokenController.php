<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\FormatarDataController;

class TokenController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $posicaoDoToken = rand(1, $request->session('cartaoToken')->get('cartaoToken')->qtdToken);
        return view('login.passo_02', [
            'mensagem' => FormatarDataController::formatarData(),
            'posicaoDoToken' => $posicaoDoToken
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cartaoToken =  $request->session()->get('cartaoToken');
        $validar = 0;
        foreach ($cartaoToken->tokens as  $value) {
            if (
                $request->posicaoDoToken == $value->posicao &&
                $request->token == $value->token
            ) {
                $validar = 1;
                break;
            }
        }
        if ($validar) {
            return redirect('/home');
        } else {
            return redirect()
                ->action('App\Http\Controllers\TokenController@create')
                ->with('error', "Digite um token válido!");
        }
    }
}
