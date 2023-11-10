<?php

namespace App\Http\Controllers\Comissao;

use App\Models\Planilha;
use App\Models\Comissao\ServicoAlarme;
use App\Http\Controllers\Controller;
use App\Models\Comissao\TecnicaDeRastreamento;
use App\Models\comissao\ComercialAlarmeCercaEletricaCFTV;

class ComissaoController extends Controller
{
    public function index($id)
    {
        $planilha = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        $comissoes = $this->getComissoes($planilha->tipoPlanilha->formulario, $id);
        $data = [
            'planilha' => $planilha,
            'formulario' => $planilha->tipoPlanilha->formulario,
            'listaComissao' => $comissoes,
        ];

        if ($this->getServicoAlarme($planilha->tipoPlanilha->formulario)) {
            $data['servico_alarme'] = ServicoAlarme::all();
        }

        return view('comissao.index', $data);
    }

    private function getServicoAlarme($tipoPlanilha)
    {
        $dataArrayFormularioAlarmes = [
            'comercialAlarmeCercaEletricaCFTV',
            'tecnicaAlarmesCercaEletricaCFTV',
            'supervisaoComercialAlarmesCercaEletricaCFTV'
        ];
        if (in_array($tipoPlanilha, $dataArrayFormularioAlarmes)) {
            return true;
        }
        return false;
    }

    private function getComissoes($tipoPlanilha, $id)
    {
        switch ($tipoPlanilha) {
            case 'tecnicaDeRastreamento':
                return  TecnicaDeRastreamento::where('planilha_id', $id)
                    ->orderBy('id', 'desc')
                    ->paginate(10); // Defina o número desejado de itens por página, neste caso, 10
            case 'comercialAlarmeCercaEletricaCFTV':
                return  ComercialAlarmeCercaEletricaCFTV::where('planilha_id', $id)
                    ->orderBy('id', 'desc')
                    ->paginate(10); // Defina o número desejado de itens por página, neste caso, 10
        }
    }
}
