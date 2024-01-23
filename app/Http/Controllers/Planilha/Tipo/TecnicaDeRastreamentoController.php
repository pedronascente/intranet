<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\TecnicaDeRastreamento;
use App\Http\Controllers\Help\CaniveteHelp;
class TecnicaDeRastreamentoController extends Controller
{
    private $titulo;
    private $tecnicaDeRastreamento;

    public function __construct(TecnicaDeRastreamento $tecnicaDeRastreamento)
    {
        $this->titulo                = "Técnica de Rastreamento";
        $this->tecnicaDeRastreamento = $tecnicaDeRastreamento;
    }

    public function store(Request $request)
    {

        dd($request->all());

        $request->validate($this->tecnicaDeRastreamento->rules(), $this->tecnicaDeRastreamento->feedback());
        $objetoModel = $this->tecnicaDeRastreamento;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->placa             = $request->placa;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->observacao        = $request->observacao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->tecnicaDeRastreamento->findOrFail($id);
        return view('planilha.tipo.tecnicaDeRastreamento.edit', [
            'comissao' => $comissao,
            'titulo'   => $this->titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->tecnicaDeRastreamento->rules(), $this->tecnicaDeRastreamento->feedback());
        $objetoModel = $this->tecnicaDeRastreamento->findOrFail($id);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->placa             = $request->placa;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->observacao        = $request->observacao;
        $objetoModel->save();
        return redirect()
            ->route('tecnica-de-rastreamento.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->tecnicaDeRastreamento->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
