<?php

namespace App\Http\Controllers\Comissao;

use App\Models\Planilha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComissaoController extends Controller
{
    private $actionIndex;
    private $paginate;

    public function __construct()
    {
        $this->paginate = 10;
        $this->actionIndex = '';
    }

    public function AddComissao($id)
    {
        $planilha = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        return view(
            'comissao.create',
            [
                'planilha' => $planilha,
                'formulario' => $planilha->tipoPlanilha->formulario
            ]
        );
    }

    public function edit($id)
    {
        return view(
            'comissao.comissao.formulario.edit.form1',
        );
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
