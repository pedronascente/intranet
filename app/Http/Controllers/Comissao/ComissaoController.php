<?php

namespace App\Http\Controllers\Comissao;

use App\Models\Comissao\Meio;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Models\Comissao\ServicoAlarme;
use App\Models\Comissao\TecnicaDeRastreamento;
use App\Models\comissao\EntregaDeAlarme;
use App\Models\comissao\ComercialRastreamentoVeicular;
use App\Models\comissao\ComercialAlarmeCercaEletricaCFTV;

class ComissaoController extends Controller
{
    public function index($id)
    {
        $planilha = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        $comissoes = $this->getComissoes($planilha->tipoPlanilha->formulario, $id);
        $data = [
            'titulo' => $planilha->tipoPlanilha->nome,
            'planilha' => $planilha,
            'formulario' => $planilha->tipoPlanilha->formulario,
            'listaComissao' => $comissoes,
        ];

        //Serviços de alarmes:
        if ($this->getServicoAlarme($planilha->tipoPlanilha->formulario)) {
            $data['servico_alarme'] = ServicoAlarme::all();
        }

        //Meio
        if ($this->getMeio($planilha->tipoPlanilha->formulario)) {
            $data['meios'] = Meio::all();
        }
        return view('comissao.index', $data);
    }

    public function formatarData($dataEntrada)
    {
        // Verificar se a barra está presente na string
        if (strpos($dataEntrada, '/') === false) {
            // Se não houver barra, retornar false
            return false;
        }
        // Quebrar a data em dia, mês e ano
        list($dia, $mes, $ano) = explode("/", $dataEntrada);
        // Formatar a data no formato desejado: "2023/04/06"
        $dataFormatada = $ano . "-" . $mes . "-" . $dia;
        // Saída da data formatada
        return $dataFormatada;
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

    private function getMeio($tipoPlanilha)
    {
        $dataArrayFormularioAlarmes = [
            'comercialAlarmeCercaEletricaCFTV',
        ];
        if (in_array($tipoPlanilha, $dataArrayFormularioAlarmes)) {
            return true;
        }
        return false;
    }

    private function getComissoes($tipoPlanilha)
    {
        // dd($tipoPlanilha);
        switch ($tipoPlanilha) {
            case 'tecnicaDeRastreamento':
                return TecnicaDeRastreamento::orderBy('id', 'desc')->paginate(10);
            case 'comercialAlarmeCercaEletricaCFTV':
                return ComercialAlarmeCercaEletricaCFTV::with(['servico', 'meio'])
                    ->orderBy('id', 'desc')->paginate(10);
            case 'comercialRastreamentoVeicular':
                return ComercialRastreamentoVeicular::orderBy('id', 'desc')->paginate(10);
            case 'entregaDeAlarmes':
                return EntregaDeAlarme::orderBy('id', 'desc')->paginate(10);
            default:
                // Lidar com outros casos ou lançar uma exceção, se necessário
                return null;
        }
    }
}
