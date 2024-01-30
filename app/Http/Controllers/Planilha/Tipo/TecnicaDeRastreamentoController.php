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

    public function index(){
        return redirect()
                ->back();
    }

    public function show($id){
        return redirect()
                ->back();
    }

    public function store(Request $request)
    {
        $request->validate($this->tecnicaDeRastreamento->rules(), $this->tecnicaDeRastreamento->feedback());
        if ($this->tecnicaDeRastreamento->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->tecnicaDeRastreamento;
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->placa             = $request->placa;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->observacao        = $request->observacao;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->save();
        return redirect()
            ->back()
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
        if ($this->tecnicaDeRastreamento->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->tecnicaDeRastreamento->findOrFail($id);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->placa             = $request->placa;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->observacao        = $request->observacao;
        $objetoModel->save();



        return redirect()
            ->back()
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->tecnicaDeRastreamento->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
