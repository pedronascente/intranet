<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\comissao\EntregaDeAlarme;

class EntregaDeAlarmeController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Entregas de Alarmes";
        $this->comissao = new ComissaoController();
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);

        $entregaDeAlarme  =  new EntregaDeAlarme();
        $entregaDeAlarme->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $entregaDeAlarme->cliente           = $request->cliente;
        $entregaDeAlarme->data              = $this->comissao->formatarData($request->data);
        $entregaDeAlarme->conta_pedido      = $request->conta_pedido;
        $entregaDeAlarme->comissao          = $request->comissao;
        $entregaDeAlarme->desconto_comissao = $request->desconto_comissao;
        $entregaDeAlarme->save();

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        return view('comissao.formulario.edit.entregaDeAlarmes', [
            'comissao' => EntregaDeAlarme::findOrFail($id),
            'titulo' => $this->titulo
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $data_array = $request->only([
            'cliente',
            'data',
            'conta_pedido',
            'comissao',
            'desconto_comissao',
        ]);
        $data_array['data'] = $this->comissao->formatarData($request->data);;
        $entregaDeAlarme = EntregaDeAlarme::findOrFail($id);
        $entregaDeAlarme->update($data_array);
        return redirect()
            ->route('entrega.alarme.edit', $id)
            ->with('status', 'Registro atualizado.');
    }
    public function destroy(Request $request, $id)
    {
        $entregaDeAlarme  = EntregaDeAlarme::findOrFail($request->id);
        $entregaDeAlarme->delete();
        return redirect(route('comissao.index', $entregaDeAlarme->planilha_id))
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
