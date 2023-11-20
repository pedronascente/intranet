<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\comissao\Planilha;
use App\Models\comissao\EntregaDeAlarme;

class EntregaDeAlarme extends Controller
{
    public function store(Request $request)
    {

        dd($request->all());






        /*
"planilha_id" => "2"
  "_token" => "Q9oJ8zrATrrLDbz2a3M7uvAtKTNeBGZBOmkA6Ut6"
  "cliente" => "23423234234"
  "data" => "23/02/3232"
  "conta_pedido" => "33333333333333333333333334444444444444444444444444"
  "comissao" => "234"
  "desconto_comissao" => "23"


            $this->validarFormulario($request);

        $entregasDeAlarmes->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $entregasDeAlarmes->cliente           = $request->cliente;
        $entregasDeAlarmes->data              = $this->comissao->formatarData($request->data);
        $entregasDeAlarmes->conta_pedido      = $request->conta_pedido;
        $entregasDeAlarmes->placa             = $request->placa;
        $entregasDeAlarmes->comissao          = $request->comissao;
        $entregasDeAlarmes->desconto_comissao = $request->desconto_comissao;
        $entregasDeAlarmes->observacao        = $request->observacao;
        $entregasDeAlarmes->save();

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
*/
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
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
