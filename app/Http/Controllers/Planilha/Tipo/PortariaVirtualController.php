<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\Meio;
use App\Models\Planilha\Tipo\PortariaVirtual;
use App\Models\Planilha\Tipo\PlanilhaTipo;

class PortariaVirtualController extends Controller
{
    private $titulo;
    private $planilhaTipo;
    private $portariaVirtual;

    public function __construct(PortariaVirtual $portariaVirtual)
    {
        $this->titulo = "Portaria Virtual";
        $this->planilhaTipo = new PlanilhaTipo();
        $this->portariaVirtual = $portariaVirtual;
    }

    public function store(Request $request)
    {
        $request->validate($this->portariaVirtual->rules(), $this->portariaVirtual->feedback());
        $objetoModel = $this->portariaVirtual;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->meio()->associate(Meio::find($request->meio_id));
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->data               = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->ins_vendas         = $request->ins_vendas;
        $objetoModel->mensal             = $request->mensal;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->portariaVirtual->findOrFail($id);
        $titulo   = $this->titulo;
        $meios    = Meio::all();
        return view('planilha.tipo.portariaVirtual.edit', [
            'comissao' => $comissao,
            'titulo' => $titulo,
            'meios' => $meios
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->portariaVirtual->rules(), $this->portariaVirtual->feedback());
        $objetoModel = $this->portariaVirtual->findOrFail($id);
        $objetoModel->meio()->associate(Meio::find($request->meio_id));
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->data               = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->ins_vendas         = $request->ins_vendas;
        $objetoModel->mensal             = $request->mensal;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('portaria-virtual.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->portariaVirtual->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
