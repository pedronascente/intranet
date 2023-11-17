<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Comissao\ComissaoController;
use App\Models\comissao\ComercialRastreamentoVeicular as CRV;

class ComercialRastreamentoVeicular extends Controller
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
        $crv = new CRV();

        $crv->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $crv->id_contrato        =  $request->id_contrato;
        $crv->cliente            =  $request->cliente;
        $crv->data               =  $this->comissao->formatarData($request->data);
        $crv->placa              =  $request->placa;
        $crv->comissao           =  $request->comissao;
        $crv->taxa_instalacao    =  $request->taxa_instalacao;
        $crv->mensal             =  $request->mensal;
        $crv->desconto_comissao  =  $request->desconto_comissao;

        $crv->save();
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
        $crv  = CRV::findOrFail($id); // Encontre o modelo com base no I
        $crv->update($data_array); // Atualize os dados do modelo com os valores do array
        // Se você quiser redirecionar ou retornar uma resposta de sucesso, faça isso aqui.
        return redirect()
            ->route('comercialRastreamentoVeicular.edit', $id)
            ->with('status', 'Sucess ao atualizar os dados.');
    }

    public function destroy(Request $request, $id)
    {
        $crv  = CRV::findOrFail($request->id);
        $crv->delete();
        return redirect(route('comissao.index', $crv->planilha_id))
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
