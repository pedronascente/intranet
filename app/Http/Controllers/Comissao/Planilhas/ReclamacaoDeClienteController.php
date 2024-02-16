<?php

namespace App\Http\Controllers\Comissao\Planilhas;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Planilha\Tipo\ReclamacaoDeCliente;
class ReclamacaoDeClienteController extends Controller
{
    private $titulo;
    private $reclamacaoDeCliente;

    public function __construct(ReclamacaoDeCliente $reclamacaoDeCliente)
    {
        $this->titulo              = "Reclamação de Cliente";
        $this->reclamacaoDeCliente = $reclamacaoDeCliente;
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
        $request->validate($this->reclamacaoDeCliente->rules(), $this->reclamacaoDeCliente->feedback());
        if ($this->reclamacaoDeCliente->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }

        $objetoModel = $this->reclamacaoDeCliente;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();

        return redirect()
            ->back()
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->reclamacaoDeCliente->findOrFail($id);
        $titulo   = $this->titulo;
        return view('planilha.tipo.reclamacaoDeCliente.colaborador.edit', [
            'comissao' => $comissao,
            'titulo'   => $titulo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->reclamacaoDeCliente->rules(), $this->reclamacaoDeCliente->feedback());
        $objetoModel = $this->reclamacaoDeCliente->findOrFail($id);

        if ($this->reclamacaoDeCliente->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }

        $objetoModel->cliente           = $request->cliente;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
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
        $objetoModel = $this->reclamacaoDeCliente->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
