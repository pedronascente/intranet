<?php

namespace App\Http\Controllers\Automacao\ReguaAutomatica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function index()
    {
        
        $titulo = "Regua Automática";
        return view("automacao.reguaAutomatica.index", [
            'titulo' => $titulo,
        ]);
    }
}
