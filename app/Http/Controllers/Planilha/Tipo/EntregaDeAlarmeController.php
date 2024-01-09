<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\EntregaDeAlarmes;
use App\Models\Planilha\Tipo\PlanilhaTipo;

class EntregaDeAlarmeController extends Controller
{
    private $titulo;
    private $planilhaTipo;
    private $entregaDeAlarme;

    public function __construct(EntregaDeAlarmes  $entregaDeAlarme)
    {
        $this->titulo          = "Entregas de Alarmes";
        $this->planilhaTipo    = new PlanilhaTipo();
        $this->entregaDeAlarme = $entregaDeAlarme;
    }

    public function store(Request $request)
    {
        $request->validate($this->entregaDeAlarme->rules(), $this->entregaDeAlarme->feedback());

        if ($this->validaDuplicidade($request)) {
            // Se a comissão já existe, você pode decidir o que fazer aqui, talvez mostrar uma mensagem de erro.
            return redirect()->back()->with('error', 'Comissão já existe para os critérios fornecidos.');
        }

        $objetoModel = $this->entregaDeAlarme;
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->cliente = $request->cliente;
        $objetoModel->data = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->conta_pedido = $request->conta_pedido;
        $objetoModel->comissao = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();

        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', 'Registrado com sucesso!');
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

        if ($this->validaDuplicidade($request)) {
            // Se a comissão já existe, você pode decidir o que fazer aqui, talvez mostrar uma mensagem de erro.
            return redirect()->back()->with('error', 'Comissão já existe para os critérios fornecidos.');
        }
    
        $objetoModel                    = $this->entregaDeAlarme->findOrFail($id);
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


    public function validaDuplicidade($request){
      
        $existingComissao = $this->entregaDeAlarme
            ->where('cliente', $request->input('cliente'))
            ->where('conta_pedido', $request->input('conta_pedido'))
            ->where('comissao', $request->input('comissao'))
            ->where('desconto_comissao', $request->input('desconto_comissao'))
            ->where('data', $this->planilhaTipo->formatarData($request->data))
            ->first();

        return $existingComissao;
        
    }
}
