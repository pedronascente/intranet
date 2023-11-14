<?php

namespace App\Http\Controllers\Comissao;

use App\Models\Comissao\Planilha;
use App\Models\Comissao\Meio;
use App\Models\Comissao\ServicoAlarme;
use App\Models\Comissao\TecnicaDeRastreamento;
use App\Models\comissao\ComercialAlarmeCercaEletricaCFTV;

use App\Http\Controllers\Controller;

class ComissaoController extends Controller
{
    /*
            1 - Recuperar a planilha da base de dados , parametro planilha_id;
            2 - Recuperar todas as comissões da respectiva planilha;
            3 - 
    */
    public function index($id)
    {
        $planilha = Planilha::with('colaborador', 'periodo', 'tipoPlanilha')->findOrFail($id);
        $comissoes = $this->getComissoes($planilha->tipoPlanilha->formulario, $id);
        $data = [
            'planilha' => $planilha,
            'formulario' => $planilha->tipoPlanilha->formulario,
            'listaComissao' => $comissoes,
        ];

        //Serviços de alarmes:
        if ($this->getServicoAlarme($planilha->tipoPlanilha->formulario)) {
            $data['servico_alarme'] = ServicoAlarme::all();
        }

        //Meio
        //Serviços de alarmes:
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

    private function getComissoes($tipoPlanilha, $id)
    {
        switch ($tipoPlanilha) {
            case 'tecnicaDeRastreamento':
                return  TecnicaDeRastreamento::where('planilha_id', $id)
                    ->orderBy('id', 'desc')
                    ->paginate(10); // Defina o número desejado de itens por página, neste caso, 10
            case 'comercialAlarmeCercaEletricaCFTV':
                return  ComercialAlarmeCercaEletricaCFTV::with(['servico', 'meio'])->where('planilha_id', $id)
                    ->orderBy('id', 'desc')
                    ->paginate(10); // Defina o número desejado de itens por página, neste caso, 10
        }
    }
}
