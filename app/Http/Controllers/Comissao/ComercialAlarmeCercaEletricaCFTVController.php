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
        $caccftv = new CACCFTV();
        $caccftv->planilha()->associate(Planilha::find($request->planilha_id));
        $caccftv->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $caccftv->meio()->associate(Meio::findOrFail($request->meio_id));
        $caccftv->data              =  $this->comissao->formatarData($request->data);
        $caccftv->cliente           =  $request->cliente;
        $caccftv->conta_pedido      =  $request->conta_pedido;
        $caccftv->ins_venda         =  $request->ins_venda;
        $caccftv->mensal            =  $request->mensal;
        $caccftv->comissao          =  $request->comissao;
        $caccftv->desconto_comissao =  $request->desconto_comissao;
        $caccftv->save();

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
        $caccftv = CACCFTV::findOrFail($id);
        $caccftv->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $caccftv->meio()->associate(Meio::findOrFail($request->meio_id));
        $caccftv->data              = $this->comissao->formatarData($request->data);
        $caccftv->cliente           = $request->cliente;
        $caccftv->conta_pedido      = $request->conta_pedido;
        $caccftv->ins_venda         = $request->ins_venda;
        $caccftv->mensal            = $request->mensal;
        $caccftv->comissao          = $request->comissao;
        $caccftv->desconto_comissao = $request->desconto_comissao;
        $caccftv->save();

        return redirect(route('comissao.index', $caccftv->planilha_id))
            ->with('status', "Atualizado com sucesso!");
    }

    public function destroy(Request $request, $id)
    {
        $caccftv  = CACCFTV::findOrFail($request->id);
        $caccftv->delete();
        return redirect(route('comissao.index', $caccftv->planilha_id))
            ->with('status', "Registro excluido com sucesso!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y',
                'servico_id' => 'required',
                'meio_id' => 'required',
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
                'ins_venda' => [
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
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido d/m/Y',
            ]
        );
    }
}
