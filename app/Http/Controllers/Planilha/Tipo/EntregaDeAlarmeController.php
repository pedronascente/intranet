<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Planilha\Tipo\EntregaDeAlarmes;

class EntregaDeAlarmeController extends Controller
{
    private $titulo;
    private $entregaDeAlarme;

    public function __construct(EntregaDeAlarmes  $entregaDeAlarme)
    {
        $this->titulo          = "Entregas de Alarmes";
        $this->entregaDeAlarme = $entregaDeAlarme;
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
        $request->validate($this->entregaDeAlarme->rules(), $this->entregaDeAlarme->feedback());
        if ($this->entregaDeAlarme->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->entregaDeAlarme;
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registrado com sucesso!');
    }

    public function edit($id)
    {
        return view('planilha.tipo.entregaDeAlarmes.edit', [
            'comissao' => $this->entregaDeAlarme->findOrFail($id),
            'titulo'   => $this->titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->entregaDeAlarme->rules(), $this->entregaDeAlarme->feedback());
        if ($this->entregaDeAlarme->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->entregaDeAlarme->findOrFail($id);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->entregaDeAlarme->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registro excluido com sucesso!");
    }
}
