<?php

namespace App\Http\Controllers;

use App\Models\Planilha;
use Illuminate\Http\Request;

class ComissaoController extends Controller
{
    public function AddComissao($id)
    {
        /*
            * [x] Buscar dados da planilha na base de dados
            * [x] Pegar o nome do formulario na tabela tipoPlanilha
            * [x] Retornar view do formulario pra criar a comissão
        
        */
        $planilha = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        return view(
            'comissao.formulario.' . $planilha->tipoPlanilha->formulario,
            [
                'planilha' => $planilha
            ]
        );
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
