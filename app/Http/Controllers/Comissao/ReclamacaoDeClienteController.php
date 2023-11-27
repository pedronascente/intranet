<?php

namespace App\Http\Controllers\Comissao;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Models\comissao\ReclamacaoDeCliente;
use App\Http\Controllers\Comissao\ComissaoController;

class ReclamacaoDeClienteController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Reclamação de Cliente";
        $this->comissao = new ComissaoController();
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $objetoModel = new ReclamacaoDeCliente();
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->data              = $this->comissao->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = ReclamacaoDeCliente::findOrFail($id);
        $titulo   = $this->titulo;
        return view('comissao.formulario.edit.reclamacaoDeCliente', [
            'comissao' => $comissao,
            'titulo' => $titulo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $objetoModel                     = ReclamacaoDeCliente::findOrFail($id);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->data               = $this->comissao->formatarData($request->data);
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('reclamacao.de.cliente.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy(Request $request, $id)
    {
        $objetoModel = ReclamacaoDeCliente::findOrFail($request->id);
        $objetoModel->delete();
        return redirect(route('comissao.index', $objetoModel->planilha_id))
            ->with('status', "Registro excluido com sucesso!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y', // Validar o formato da data
                'conta_pedido' => 'required|max:50',
                'comissao' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if (
                            $value < 0 || $value > 9999999.99
                        ) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
                'desconto_comissao' => [
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if (
                            $value < 0 || $value > 9999999.99
                        ) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
            ],
            [
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido dia/mes/ano'
            ],
        );
    }
}
