<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\Planilha\Tipo\SupervisaoComercialRastreamento;

class SupervisaoComercialRastreamentoController extends Controller
{
    private $titulo;
    private $planilhaTipo;
    private $supervisaoComercialRastreamento;

    public function __construct(SupervisaoComercialRastreamento $supervisaoComercialRastreamento)
    {
        $this->titulo                          = "Supervisão Comercial Rastreamento";
        $this->planilhaTipo                    = new PlanilhaTipo();
        $this->supervisaoComercialRastreamento = $supervisaoComercialRastreamento;
    }

    public function store(Request $request)
    {
        $request->validate($this->supervisaoComercialRastreamento->rules(), $this->supervisaoComercialRastreamento->feedback());
        $objetoModel = $this->supervisaoComercialRastreamento;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->data               = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->total_rastreadores = $request->total_rastreadores;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->supervisaoComercialRastreamento->findOrFail($id);
        return view('planilha.tipo.supervisaoComercialRastreamento.edit', [
            'titulo' => $this->titulo,
            'comissao' => $comissao,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->supervisaoComercialRastreamento->rules(), $this->supervisaoComercialRastreamento->feedback());
        $objetoModel = $this->supervisaoComercialRastreamento->findOrFail($id);
        $objetoModel->data               = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->total_rastreadores = $request->total_rastreadores;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('supervisao-c-r.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->supervisaoComercialRastreamento->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
