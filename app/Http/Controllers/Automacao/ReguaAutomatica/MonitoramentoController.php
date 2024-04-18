<?php

namespace App\Http\Controllers\Automacao\ReguaAutomatica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Automacao\ReguaAutomatica\Condominio;

class MonitoramentoController extends Controller
{
    public function index(){
        
        $titulo = "Listar Condonios";
        $collerction = Condominio::all();

        return view("automacao.reguaAutomatica.monitoramento.condominio.index", [
            'titulo' => $titulo,
            'collerction' => $collerction,
            
        ]);
    }

    public function show($id){
        $condominio = Condominio::with('regua')->findOrFail($id);
        $titulo = "Monitoramento";
        return view("automacao.reguaAutomatica.monitoramento.condominio.show", [
            'titulo' => $titulo,
            'condominio' => $condominio,
        ]);
    }
}
