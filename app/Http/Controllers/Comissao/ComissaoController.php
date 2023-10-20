<?php

namespace App\Http\Controllers\Comissao;

use App\Models\Planilha;
use App\Models\ServicoAlarme;
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
        $dataArray = [
            'planilha' => $planilha,
            'formulario' => $planilha->tipoPlanilha->formulario
        ];

        $dataArrayFormularioAlarmes = [
            'comercialAlarmeCercaEletricaCFTV',
            'tecnicaAlarmesCercaEletricaCFTV',
            'supervisaoComercialAlarmesCercaEletricaCFTV'
        ];

        if (in_array($planilha->tipoPlanilha->formulario, $dataArrayFormularioAlarmes)) {
            $dataArray['servico_alarme'] = ServicoAlarme::all();
        }

        return view('comissao.create', $dataArray);
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
