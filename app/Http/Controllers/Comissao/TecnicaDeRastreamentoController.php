<?php

namespace App\Http\Controllers\comissao;

use App\Models\Planilha;
use App\Models\TecnicaDeRastreamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TecnicaDeRastreamentoController extends Controller
{
    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $comissao = new TecnicaDeRastreamento();
        $comissao->cliente = $request->cliente;
        $comissao->data = $this->foramatarData($request->data);
        $comissao->conta_pedido = $request->conta_pedido;
        $comissao->placa = $request->placa;
        $comissao->comissao =  $request->comissao;
        $comissao->desconto_comissao = $request->desconto_comissao;
        $comissao->observacao = $request->observacao;
        $comissao->planilha()->associate(Planilha::findOrFail($request->planilha_id));
        $comissao->save();

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        return view('comissao.comissao.formulario.edit.tecnicaDeRastreamento', [
            'comissao' => TecnicaDeRastreamento::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $data_array = $request->only([
            'cliente',
            'conta_pedido',
            'placa',
            'comissao',
            'desconto_comissao',
            'observacao',
        ]);
        $data_array['data'] = $this->foramatarData($request->data);
        try {
            $seuModelo = TecnicaDeRastreamento::findOrFail($id); // Encontre o modelo com base no ID
            // dd($seuModelo);
            $seuModelo->update($data_array); // Atualize os dados do modelo com os valores do array
            // Se você quiser redirecionar ou retornar uma resposta de sucesso, faça isso aqui.
            return redirect()
                ->route('tecnicaDeRastreamento.edit', $id)
                ->with('status', 'Sucess ao atualizar os dados.');
        } catch (\Exception $e) {
            // Se ocorrer um erro, você pode lidar com ele aqui.
            dd($e);
            return back()->with('error', 'Erro ao atualizar os dados.');
        }
    }

    public function destroy(Request $request, $id)
    {
        $comissao = TecnicaDeRastreamento::findOrFail($request->id);
        $comissao->delete();
        return redirect(route('comissao.index', $comissao->planilha_id))
            ->with('status', "Registro excluido com sucesso!");
    }

    private function foramatarData($dataEntrada)
    {
        // Quebrar a data em dia, mês e ano
        list($dia, $mes, $ano) = explode("/", $dataEntrada);
        // Formatar a data no formato desejado: "2023/04/06"
        $dataFormatada = $ano . "-" . $mes . "-" . $dia;
        // Saída da data formatada
        return  $dataFormatada;
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y', // Validar o formato da data
                'conta_pedido' => 'required|max:50',
                'placa' => 'required|max:10',
                'comissao' =>
                [
                    'required', // Campo obrigatório
                    'numeric', // Deve ser um número
                    'regex:/^\d+(\.\d{1,2})?$/' // Deve ser um número decimal com até 2 casas decimais
                ],
            ],
            [
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido d/m/Y'
            ],
        );
    }
}
