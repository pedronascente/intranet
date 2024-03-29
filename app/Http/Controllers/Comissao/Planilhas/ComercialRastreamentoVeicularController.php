<?php

namespace App\Http\Controllers\Comissao\Planilhas;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Comissao\Planilhas\ComercialRastreamentoVeicular;
class ComercialRastreamentoVeicularController extends Controller
{
    private $titulo;
    private $comercialRastreamentoVeicular;

    public function __construct(ComercialRastreamentoVeicular $comercialRastreamentoVeicular)
    {
        $this->titulo = "Comercial Rastreamento Veicular";
        $this->comercialRastreamentoVeicular = $comercialRastreamentoVeicular;
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
        $request->validate($this->comercialRastreamentoVeicular->rules(), $this->comercialRastreamentoVeicular->feedback());
        if ($this->comercialRastreamentoVeicular->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel = $this->comercialRastreamentoVeicular;
        $this->preencherAtributosDoObjeto($request, $objetoModel);
        return redirect()
            ->back()
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->comercialRastreamentoVeicular->findOrFail($id);
        $titulo   = $this->titulo;
        return view('comissao.planilhas.comercialRastreamentoVeicular.colaborador.edit', [
            'comissao' => $comissao,
            'titulo'   => $titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->comercialRastreamentoVeicular->rules(), $this->comercialRastreamentoVeicular->feedback());
        if ($this->comercialRastreamentoVeicular->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel = $this->comercialRastreamentoVeicular->findOrFail($id);
        $this->preencherAtributosDoObjeto($request, $objetoModel);
        return redirect()
            ->back()
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->comercialRastreamentoVeicular->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registrado Excluido com sucesso!");
    }

    private function preencherAtributosDoObjeto(Request $request, $objetoModel)
    {
        $objetoModel->id_contrato       = $request->id_contrato;
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->placa             = $request->placa;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->taxa_instalacao   = $request->taxa_instalacao;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
            
        if($request->planilha_id){
                    $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        }

        $objetoModel->save();
    }
}