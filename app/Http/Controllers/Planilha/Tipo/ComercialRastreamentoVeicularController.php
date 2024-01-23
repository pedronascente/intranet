<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Planilha\Tipo\ComercialRastreamentoVeicular;
class ComercialRastreamentoVeicularController extends Controller
{
    private $titulo;
    private $comercialRastreamentoVeicular;

    public function __construct(ComercialRastreamentoVeicular $comercialRastreamentoVeicular)
    {
        $this->titulo = "Comercial Rastreamento Veicular";
        $this->comercialRastreamentoVeicular = $comercialRastreamentoVeicular;
    }

    public function store(Request $request)
    {
        $request->validate($this->comercialRastreamentoVeicular->rules(), $this->comercialRastreamentoVeicular->feedback());
        $objetoModel = $this->comercialRastreamentoVeicular;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->id_contrato       = $request->id_contrato;
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->placa             = $request->placa;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->taxa_instalacao   = $request->taxa_instalacao;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->comercialRastreamentoVeicular->findOrFail($id);
        $titulo   = $this->titulo;
        return view('planilha.tipo.comercialRastreamentoVeicular.edit', [
            'comissao' => $comissao,
            'titulo'   => $titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->comercialRastreamentoVeicular->rules(), $this->comercialRastreamentoVeicular->feedback());
        $objetoModel                    = $this->comercialRastreamentoVeicular->findOrFail($id);
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->id_contrato       = $request->id_contrato;
        $objetoModel->placa             = $request->placa;
        $objetoModel->taxa_instalacao   = $request->taxa_instalacao;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('comercial-rastreamento-veicular.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->comercialRastreamentoVeicular->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
