<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Planilha\Tipo\ServicoAlarme;
use App\Models\Planilha\Tipo\SupervisaoComercialAlarmesCercaEletricaCFTV;
class SupervisaoComercialAlarmesCercaEletricaCFTVController extends Controller
{
    private $titulo;
    private $scace_cftv;

    public function __construct(SupervisaoComercialAlarmesCercaEletricaCFTV $scace_cftv)
    {
        $this->titulo     = "Supervisão Comercial Alarmes / Cerca Elétrica / CFTV";
        $this->scace_cftv = $scace_cftv;
    }

    public function store(Request $request)
    {
        $request->validate($this->scace_cftv->rules(), $this->scace_cftv->feedback());
        $objetoModel = $this->scace_cftv;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->data               = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->consultor          = $request->consultor;
        $objetoModel->mensal             = $request->mensal;
        $objetoModel->ins_vendas         = $request->ins_vendas;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao       = $this->scace_cftv->findOrFail($id);
        $servico_alarme = ServicoAlarme::all();
        return view('planilha.tipo.supervisaoComercialAlarmesCercaEletricaCFTV.edit', [
            'titulo'         => $this->titulo,
            'comissao'       => $comissao,
            'servico_alarme' => $servico_alarme,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->scace_cftv->rules(), $this->scace_cftv->feedback());
        $objetoModel = $this->scace_cftv->findOrFail($id);
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->consultor         = $request->consultor;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('supervisao-cace-cftv.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->scace_cftv->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
