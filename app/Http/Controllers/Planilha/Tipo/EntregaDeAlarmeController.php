<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\EntregaDeAlarme;
use App\Models\Planilha\Tipo\PlanilhaTipo;

class EntregaDeAlarmeController extends Controller
{
    private $titulo;
    private $planilhaTipo;
    private $entregaDeAlarme;

    public function __construct(EntregaDeAlarme  $entregaDeAlarme)
    {
        $this->titulo = "Entregas de Alarmes";
        $this->planilhaTipo = new PlanilhaTipo();
        $this->entregaDeAlarme = $entregaDeAlarme;
    }

    public function store(Request $request)
    {
        $request->validate($this->entregaDeAlarme->rules(), $this->entregaDeAlarme->feedback());
        $objetoModel = $this->entregaDeAlarme;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        return view('planilha.tipo.entregaDeAlarmes.edit', [
            'comissao' => $this->entregaDeAlarme->findOrFail($id),
            'titulo' => $this->titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->entregaDeAlarme->rules(), $this->entregaDeAlarme->feedback());
        $objetoModel = $this->entregaDeAlarme->findOrFail($id);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('entrega-de-alarme.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel  = $this->entregaDeAlarme->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registro excluido com sucesso!");
    }
}
