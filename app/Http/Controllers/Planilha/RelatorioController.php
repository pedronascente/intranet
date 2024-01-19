<?php

namespace App\Http\Controllers\planilha;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Models\planilha\PlanilhaStatus;

class RelatorioController extends Controller
{
    private $planilha;
    private $titulo;

    public function __construct(Planilha $planilha)
    {
       $this->titulo    = "Relatório";
        $this->planilha = $planilha;
    }

    public function relatorio(Request $request){
        
        $arayLisStatus = PlanilhaStatus::all();
        
        return view('planilha.administrativo.relatorio',
        [
            'titulo'=> $this->titulo,
            'arayLisStatus'=> $arayLisStatus,
            'collection'=>  $this->planilha->relatorioDb($request),
        ]);
    }

    
}
