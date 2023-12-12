<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\Planilha\Tipo\ReclamacaoDeCliente;

class ReclamacaoDeClienteController extends Controller
{
    private $titulo;
    private $PlanilhaTipo;
    private $reclamacaoDeCliente;

    public function __construct(ReclamacaoDeCliente $reclamacaoDeCliente)
    {
        $this->titulo              = "Reclamação de Cliente";
        $this->PlanilhaTipo        = new PlanilhaTipo();
        $this->reclamacaoDeCliente = $reclamacaoDeCliente;
    }

    public function store(Request $request)
    {
        $request->validate($this->reclamacaoDeCliente->rules(), $this->reclamacaoDeCliente->feedback());
        $objetoModel = $this->reclamacaoDeCliente;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->data              = $this->PlanilhaTipo->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
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
        $comissao = $this->reclamacaoDeCliente->findOrFail($id);
        $titulo   = $this->titulo;
        return view('planilha.tipo.reclamacaoDeCliente.edit', [
            'comissao' => $comissao,
            'titulo' => $titulo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->reclamacaoDeCliente->rules(), $this->reclamacaoDeCliente->feedback());
        $objetoModel = $this->reclamacaoDeCliente->findOrFail($id);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = $this->PlanilhaTipo->formatarData($request->data);
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('reclamacao-de-cliente.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->reclamacaoDeCliente->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
