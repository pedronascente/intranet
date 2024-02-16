<?php

namespace App\Http\Controllers\Comissao\Planilhas;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Comissao\Tipo\SupervisaoTecnicaESacAlarmesCercaEletricaCFTV;
class SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController extends Controller
{
    private $titulo;
    private $stsace_cftv;

    public function __construct(SupervisaoTecnicaESacAlarmesCercaEletricaCFTV $upervisaoTecnicaESacAlarmesCercaEletricaCFTV)
    {
        $this->titulo      = "Supervisão Técnica e SAC Alarmes / Cerca Elétrica / CFTV";
        $this->stsace_cftv = $upervisaoTecnicaESacAlarmesCercaEletricaCFTV;
    }

    public function index()
    {
        return redirect()
            ->back();
    }

    public function show($id)
    {
        return redirect()
            ->back();
    }

    public function store(Request $request)
    {
        $request->validate($this->stsace_cftv->rules(), $this->stsace_cftv->feedback());
        if ($this->stsace_cftv->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                     = $this->stsace_cftv;
        $objetoModel->data               = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->equipe_servico     = $request->equipe_servico;
        $objetoModel->ins_vendas         = $request->ins_vendas;
        $objetoModel->mensal             = $request->mensal;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registrado com sucesso!');
    }

    public function edit($id)
    {
        $comissao = $this->stsace_cftv->findOrFail($id);
        return view('planilha.tipo.supervisaoTecnicaESacAlarmesCercaEletricaCFTV.colaborador.edit', [
            'titulo'   => $this->titulo,
            'comissao' => $comissao,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->stsace_cftv->rules(), $this->stsace_cftv->feedback());
        if ($this->stsace_cftv->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->stsace_cftv->findOrFail($id);
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->equipe_servico    = $request->equipe_servico;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->stsace_cftv->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registrado Excluido com sucesso!");
    }
}