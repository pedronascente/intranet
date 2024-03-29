<?php

namespace App\Http\Controllers\Comissao\Administrativo;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Models\Comissao\PlanilhaStatus;
use App\Http\Controllers\Help\CaniveteHelp;
class RelatorioController extends Controller
{
    private $planilha;
    private $titulo;

    public function __construct(Planilha $planilha)
    {
        $this->titulo   = "Relatório";
        $this->planilha = $planilha;
    }

    public function getRelatorio(Request $request)
    {
        $status          = $request->input('status');
        $filtro          = $request->input('filtro');
        $dataInicial     = $request->input('data_inicial') ? CaniveteHelp::formatarDataAnoMesDia($request->input('data_inicial')) : null;
        $dataFinal       = $request->input('data_final') ? CaniveteHelp::formatarDataAnoMesDia($request->input('data_final')) : null;
        $arrayListStatus = PlanilhaStatus::all();
        $collection      = $this->planilha->getRelatorio($status, $filtro, $dataInicial, $dataFinal);
       
        return view('comissao.administrativo.relatorio',
        [
            'titulo'          => $this->titulo,
            'arrayListStatus' => $arrayListStatus,
            'collection'      => $collection,
            'inputStatus'     => $status,
        ]);
    }
}
