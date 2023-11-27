<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Comissao\ComissaoController;
use App\Models\Comissao\Planilha;
use App\Models\comissao\SupervisaoComercialRastreamento;

class SupervisaoComercialRastreamentoController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Supervisão Comercial Rastreamento";
        $this->comissao = new ComissaoController();
    }
    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $objetoModel = new  SupervisaoComercialRastreamento();
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->data               = $this->comissao->formatarData($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->total_rastreadores = $request->total_rastreadores;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = SupervisaoComercialRastreamento::findOrFail($id);
        return view('comissao.formulario.edit.supervisaoComercialRastreamento', [
            'titulo' => $this->titulo,
            'comissao' => $comissao,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $objetoModel = SupervisaoComercialRastreamento::findOrFail($id);
        $objetoModel->data               = $this->comissao->formatarData($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->total_rastreadores = $request->total_rastreadores;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('supervisao.comercial.rastreamento.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy(Request $request, $id)
    {
        $objetoModel = SupervisaoComercialRastreamento::findOrFail($id);
        $objetoModel->delete();
        return redirect(route('comissao.index', $objetoModel->planilha_id))
            ->with('status', "Registro excluido com sucesso!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y',
                'conta_pedido' => 'required|max:50',
                'total_rastreadores' => 'numeric',
                'comissao' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if ($value < 0 || $value > 9999999.99) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
                'desconto_comissao' => [
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if ($value < 0 || $value > 9999999.99) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
            ],
            [
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido d/m/Y',
            ]
        );
    }
}
