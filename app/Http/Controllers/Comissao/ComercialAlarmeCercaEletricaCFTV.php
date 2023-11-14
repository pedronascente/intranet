<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Models\Comissao\Meio;
use App\Models\comissao\Planilha;
use App\Http\Controllers\Controller;
use App\Models\Comissao\ServicoAlarme;

use App\Http\Controllers\Comissao\ComissaoController;
use App\Models\comissao\ComercialAlarmeCercaEletricaCFTV as CACCFTV;

class ComercialAlarmeCercaEletricaCFTV extends Controller
{
    private $comissao;

    public function __construct()
    {
        $this->comissao = new ComissaoController();
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $caccftv = new CACCFTV();
        $caccftv->planilha()->associate(Planilha::find($request->planilha_id));
        $caccftv->servico()->associate(ServicoAlarme::findOrFail($request->servico_alarme_id));
        $caccftv->meio()->associate(Meio::findOrFail($request->meio_id));
        $caccftv->cliente           =  $request->cliente;
        $caccftv->data              =  $this->comissao->formatarData($request->data);
        $caccftv->conta_pedido      =  $request->conta_pedido;
        $caccftv->ins_venda         =  $request->ins_venda;
        $caccftv->mensal            =  $request->mensal;
        $caccftv->comissao          =  $request->comissao;
        $caccftv->desconto_comissao =  $request->desconto_comissao;
        $caccftv->save();

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y',
                'servico_alarme_id' => 'required',
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
                'desconto_comissao' => 'numeric',
            ],
            [
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido d/m/Y',
            ]
        );
    }
}
