<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comissao\Meio;
use App\Models\comissao\Planilha;
use App\Models\Comissao\ServicoAlarme;
use App\Models\comissao\ComercialAlarmeCercaEletricaCFTV as CACCFTV;

class ComercialAlarmeCercaEletricaCFTVController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Comercial Alarme / Cerca Elétrica / CFTV";
        $this->comissao = new ComissaoController();
    }

    public function store(Request $request)
    {

       
        $this->validarFormulario($request);
        $objetoModel = new CACCFTV();
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->meio()->associate(Meio::findOrFail($request->meio_id));
        $objetoModel->data              =  $this->comissao->formatarData($request->data);
        $objetoModel->cliente           =  $request->cliente;
        $objetoModel->conta_pedido      =  $request->conta_pedido;
        $objetoModel->ins_vendas        =  $request->ins_vendas;
        $objetoModel->mensal            =  $request->mensal;
        $objetoModel->comissao          =  $request->comissao;
        $objetoModel->desconto_comissao =  $request->desconto_comissao;
        $objetoModel->save();

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = CACCFTV::findOrFail($id);
        $servico_alarme = ServicoAlarme::all();
        $meios = Meio::all();
        return view('comissao.formulario.edit.comercialAlarmeCercaEletricaCFTV', [
            'titulo' => $this->titulo,
            'comissao' => $comissao,
            'servico_alarme' => $servico_alarme,
            'meios' => $meios,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $objetoModel = CACCFTV::findOrFail($id);
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->meio()->associate(Meio::findOrFail($request->meio_id));
        $objetoModel->data              = $this->comissao->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();

        return redirect()
            ->route('comercial.alarme.cerca.eletrica.cftv.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy(Request $request, $id)
    {
        $objetoModel  = CACCFTV::findOrFail($request->id);
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
                'servico_id' => 'exists:servico_alarmes,id',
                'meio_id' => 'exists:meios,id',
                'conta_pedido' => 'required|max:50',
                'mensal' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if ($value < 0 || $value > 9999999.99) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
                'ins_vendas' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    function ($attribute, $value, $fail) {
                        if ($value < 0 || $value > 9999999.99) {
                            $fail("O campo $attribute deve estar entre 0 e 9999999.99");
                        }
                    },
                ],
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
                'meio_id.exists' => 'O meio informado não existe.',
                'servico_id.exists' => 'O Serviço informado não existe.',
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido d/m/Y',
            ]
        );
    }
}
