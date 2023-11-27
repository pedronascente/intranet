<?php

namespace App\Http\Controllers\comissao;

use App\Models\Comissao\Planilha;
use App\Models\Comissao\TecnicaDeRastreamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TecnicaDeRastreamentoController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->comissao = new ComissaoController();
        $this->titulo = "Técnica de Rastreamento";
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $tecnicaDeRastreamento  = new TecnicaDeRastreamento();
        $tecnicaDeRastreamento->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $tecnicaDeRastreamento->cliente           = $request->cliente;
        $tecnicaDeRastreamento->data              = $this->comissao->formatarData($request->data);
        $tecnicaDeRastreamento->conta_pedido      = $request->conta_pedido;
        $tecnicaDeRastreamento->placa             = $request->placa;
        $tecnicaDeRastreamento->comissao          = $request->comissao;
        $tecnicaDeRastreamento->desconto_comissao = $request->desconto_comissao;
        $tecnicaDeRastreamento->observacao        = $request->observacao;
        $tecnicaDeRastreamento->save();

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        return view('comissao.formulario.edit.tecnicaDeRastreamento', [
            'comissao' => TecnicaDeRastreamento::findOrFail($id),
            'titulo' => $this->titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $data_array = $request->only([
            'cliente',
            'conta_pedido',
            'placa',
            'comissao',
            'desconto_comissao',
            'observacao',
        ]);
        $data_array['data'] = $this->comissao->formatarData($request->data);
        $tecnicaDeRastreamento  = TecnicaDeRastreamento::findOrFail($id);
        $tecnicaDeRastreamento->update($data_array);
        return redirect()
            ->route('tecnica.de.rastreamento.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy(Request $request, $id)
    {
        $tecnicaDeRastreamento  = TecnicaDeRastreamento::findOrFail($request->id);
        $tecnicaDeRastreamento->delete();
        return redirect(route('comissao.index', $tecnicaDeRastreamento->planilha_id))
            ->with('status', "Registro excluido com sucesso!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y', // Validar o formato da data
                'conta_pedido' => 'required|max:50',
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
