<?php

namespace App\Http\Controllers\comissao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComercialAlarmeCercaEletricaCFTV extends Controller
{
    public function store(Request $request)
    {

        dd($request->all());
        $comissao = new ComercialAlarmeCercaEletricaCFTV();


        dd($comissao);

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }
}
