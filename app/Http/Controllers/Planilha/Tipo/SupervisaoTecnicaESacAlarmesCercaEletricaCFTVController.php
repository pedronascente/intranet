<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\Planilha\Tipo\SupervisaoTecnicaESacAlarmesCercaEletricaCFTV;

class SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController extends Controller
{
    private $titulo;
    private $stsace_cftv;
    private $planilhaTipo;

    public function __construct(SupervisaoTecnicaESacAlarmesCercaEletricaCFTV $upervisaoTecnicaESacAlarmesCercaEletricaCFTV)
    {
        $this->titulo = "Supervisão Técnica e SAC Alarmes / Cerca Elétrica / CFTV";
        $this->planilhaTipo = new PlanilhaTipo();
        $this->stsace_cftv = $upervisaoTecnicaESacAlarmesCercaEletricaCFTV;
    }

    public function store(Request $request)
    {
        $request->validate($this->stsace_cftv->rules(), $this->stsace_cftv->feedback());
        $objetoModel = $this->stsace_cftv;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->data               = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->equipe_servico     = $request->equipe_servico;
        $objetoModel->ins_vendas         = $request->ins_vendas;
        $objetoModel->mensal             = $request->mensal;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->stsace_cftv->findOrFail($id);
        return view('planilha.tipo.supervisaoTecnicaESacAlarmesCercaEletricaCFTV.edit', [
            'titulo' => $this->titulo,
            'comissao' => $comissao,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->stsace_cftv->rules(), $this->stsace_cftv->feedback());
        $objetoModel = $this->stsace_cftv->findOrFail($id);
        $objetoModel->data              = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->equipe_servico    = $request->equipe_servico;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('stsace-cftv.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->stsace_cftv->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
