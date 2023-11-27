<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comissao\Planilha;
use App\Models\comissao\ComercialRastreamentoVeicular as CRV;

class ComercialRastreamentoVeicularController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Comercial Rastreamento Veicular";
        $this->comissao = new ComissaoController();
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $objetoModel = new CRV();
        $objetoModel->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $objetoModel->id_contrato        =  $request->id_contrato;
        $objetoModel->cliente            =  $request->cliente;
        $objetoModel->data               =  $this->comissao->formatarData($request->data);
        $objetoModel->placa              =  $request->placa;
        $objetoModel->comissao           =  $request->comissao;
        $objetoModel->taxa_instalacao    =  $request->taxa_instalacao;
        $objetoModel->mensal             =  $request->mensal;
        $objetoModel->desconto_comissao  =  $request->desconto_comissao;
        $objetoModel->save();
        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        return view('comissao.formulario.edit.comercialRastreamentoVeicular', [
            'comissao' => CRV::findOrFail($id),
            'titulo' => $this->titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $data_array = $request->only([
            "cliente",
            "id_contrato",
            "placa",
            "taxa_instalacao",
            "mensal",
            "comissao",
            "desconto_comissao",
        ]);
        $data_array['data'] = $this->comissao->formatarData($request->data);;
        $objetoModel = CRV::findOrFail($id);
        $objetoModel->update($data_array);
        return redirect()
            ->route('comercial.rastreamento.veicular.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy(Request $request, $id)
    {
        $objetoModel  = CRV::findOrFail($request->id);
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
                'placa' => 'required|max:10',
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
                'taxa_instalacao' => [
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
                'mensal' => [
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
                'id_contrato' => 'max:10',
            ],
            [
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido dia/mes/ano'
            ],
        );
    }
}
