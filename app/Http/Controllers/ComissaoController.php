<?php

namespace App\Http\Controllers;

use App\Models\Planilha;
use Illuminate\Http\Request;

class ComissaoController extends Controller
{
    public function AddComissao($id)
    {
        $planilha = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);

        //dd($planilha->tipoPlanilha->formulario);
        return view(
            'comissao.create',
            [
                'planilha' => $planilha,
                'formulario' => $planilha->tipoPlanilha->formulario
            ]
        );
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
