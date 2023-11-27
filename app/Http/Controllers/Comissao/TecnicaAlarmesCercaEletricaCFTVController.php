<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Comissao\ComissaoController;
use App\Models\Comissao\ServicoAlarme;
use App\Models\comissao\TecnicaAlarmesCercaEletricaCFTV;

class TecnicaAlarmesCercaEletricaCFTVController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Técnica Alarmes / Cerca Elétrica / CFTV";
        $this->comissao = new ComissaoController();
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $objetoModel = new TecnicaAlarmesCercaEletricaCFTV();
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->servico()->associate(ServicoAlarme::find($request->servico_id));
        $objetoModel->data               = $this->comissao->formatarData($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->numero_os          = $request->numero_os;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = TecnicaAlarmesCercaEletricaCFTV::findOrFail($id);
        $servico_alarme = ServicoAlarme::all();

        return view('comissao.formulario.edit.TecnicaAlarmesCercaEletricaCFTV', [
            'titulo' => $this->titulo,
            'comissao' => $comissao,
            'servico_alarme' => $servico_alarme,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $objetoModel = TecnicaAlarmesCercaEletricaCFTV::findOrFail($id);
        $objetoModel->servico()->associate(ServicoAlarme::find($request->servico_id));
        $objetoModel->data               = $this->comissao->formatarData($request->data);
        $objetoModel->cliente            = $request->cliente;
        $objetoModel->conta_pedido       = $request->conta_pedido;
        $objetoModel->numero_os          = $request->numero_os;
        $objetoModel->comissao           = $request->comissao;
        $objetoModel->desconto_comissao  = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('tecnica.alarmes.cerca.eletrica.cftv.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy(Request $request, $id)
    {
        $objetoModel = TecnicaAlarmesCercaEletricaCFTV::findOrFail($id);
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
                'numero_os' => 'numeric',
                'servico_id' => 'required',
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
