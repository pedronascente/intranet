<?php

namespace App\Http\Controllers\Comissao\Planilhas;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Comissao\Tipo\SupervisaoComercialRastreamento;
class SupervisaoComercialRastreamentoController extends Controller
{
    private $titulo;
    private $supervisaoComercialRastreamento;

    public function __construct(SupervisaoComercialRastreamento $supervisaoComercialRastreamento)
    {
        $this->titulo                          = "Supervisão Comercial Rastreamento";
        $this->supervisaoComercialRastreamento = $supervisaoComercialRastreamento;
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
        $request->validate($this->supervisaoComercialRastreamento->rules(), $this->supervisaoComercialRastreamento->feedback());
        if ($this->supervisaoComercialRastreamento->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                     = $this->supervisaoComercialRastreamento;
        $objetoModel->data               = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->total_rastreadores = $request->total_rastreadores;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registrado com sucesso!');
    }

    public function edit($id)
    {
        $comissao = $this->supervisaoComercialRastreamento->findOrFail($id);
        return view('planilha.tipo.supervisaoComercialRastreamento.colaborador.edit', [
            'titulo'   => $this->titulo,
            'comissao' => $comissao,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->supervisaoComercialRastreamento->rules(), $this->supervisaoComercialRastreamento->feedback());
        if ($this->supervisaoComercialRastreamento->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                     = $this->supervisaoComercialRastreamento->findOrFail($id);
        $objetoModel->data               = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->total_rastreadores = $request->total_rastreadores;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->supervisaoComercialRastreamento->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registrado Excluido com sucesso!");
    }
}