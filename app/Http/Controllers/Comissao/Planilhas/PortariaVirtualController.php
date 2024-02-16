<?php

namespace App\Http\Controllers\Comissao\Planilhas;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\Meio;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Planilha\Tipo\PortariaVirtual;
class PortariaVirtualController extends Controller
{
    private $titulo;
    private $portariaVirtual;

    public function __construct(PortariaVirtual $portariaVirtual)
    {
        $this->titulo          = "Portaria Virtual";
        $this->portariaVirtual = $portariaVirtual;
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
        $request->validate($this->portariaVirtual->rules(), $this->portariaVirtual->feedback());
        if ($this->portariaVirtual->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                     = $this->portariaVirtual;
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->data               = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->ins_vendas         = $request->ins_vendas;
        $objetoModel->mensal             = $request->mensal;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->meio()->associate(Meio::find($request->meio_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->portariaVirtual->findOrFail($id);
        $titulo   = $this->titulo;
        $meios    = Meio::all();
        return view('planilha.tipo.portariaVirtual.colaborador.edit', [
            'comissao' => $comissao,
            'titulo'   => $titulo,
            'meios'    => $meios
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->portariaVirtual->rules(), $this->portariaVirtual->feedback());
        if ($this->portariaVirtual->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                     = $this->portariaVirtual->findOrFail($id);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->data               = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->ins_vendas         = $request->ins_vendas;
        $objetoModel->mensal             = $request->mensal;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->meio()->associate(Meio::find($request->meio_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('warning', "Atenção : Duplicar comissão não é permitido!");
    }

    public function destroy($id)
    {
        $objetoModel = $this->portariaVirtual->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registrado Excluido com sucesso!");
    }
}