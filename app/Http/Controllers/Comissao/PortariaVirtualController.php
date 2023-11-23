<?php

namespace App\Http\Controllers\comissao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Comissao\PortariaVirtual;
use App\Models\Comissao\Planilha;
use App\Models\Comissao\Meio;

class PortariaVirtualController extends Controller
{
    private $comissao;
    private $titulo;

    public function __construct()
    {
        $this->titulo = "Portaria Virtual";
        $this->comissao = new ComissaoController();
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $ptv = new PortariaVirtual();
        $ptv->planilha()->associate(Planilha::find($request->planilha_id));
        $ptv->meio()->associate(Meio::find($request->meio_id));
        $ptv->cliente            = $request->cliente;
        $ptv->data               = $this->comissao->formatarData($request->data);
        $ptv->ins_vendas         = $request->ins_vendas;
        $ptv->mensal             = $request->mensal;
        $ptv->conta_pedido       = $request->conta_pedido;
        $ptv->comissao           = $request->comissao;
        $ptv->desconto_comissao  = $request->desconto_comissao;
        $ptv->save();

        return redirect(route('comissao.index', $request->planilha_id))
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao_postaria_virtual = PortariaVirtual::findOrFail($id);
        $titulo     = $this->titulo;
        $meios      = Meio::all();

        return view('comissao.formulario.edit.portariaVirtual', [
            'comissao' => $comissao_postaria_virtual,
            'titulo' => $titulo,
            'meios' => $meios
        ]);
    }

    public function update(Request $request, $id)
    {

        $ptv = PortariaVirtual::findOrFail($id);
        $ptv->meio()->associate(Meio::find($request->meio_id));
        $ptv->cliente            = $request->cliente;
        $ptv->data               = $this->comissao->formatarData($request->data);
        $ptv->ins_vendas         = $request->ins_vendas;
        $ptv->mensal             = $request->mensal;
        $ptv->conta_pedido       = $request->conta_pedido;
        $ptv->comissao           = $request->comissao;
        $ptv->desconto_comissao  = $request->desconto_comissao;
        $ptv->save();

        return redirect(route('comissao.index', $ptv->planilha_id))
            ->with('status', "Atualizado com sucesso!");
    }

    public function destroy(Request $request, $id)
    {
        $ptv  = PortariaVirtual::findOrFail($request->id);
        $ptv->delete();

        return redirect(route('comissao.index', $ptv->planilha_id))
            ->with('status', "Registro excluido com sucesso!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'cliente' => 'required|min:2|max:200',
                'data' => 'required|date_format:d/m/Y', // Validar o formato da data
                'conta_pedido' => 'required|max:50',
                'meio_id' => 'required',
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
                'ins_vendas' => [
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
            ],
            [
                'required' => 'Campo obrigatório.',
                'comissao.regex:/^\d+(\.\d{1,2})?$/' => 'Deve ser um número decimal com até 2 casas decimais',
                'date_format' => 'O campo data deve estar no formato válido dia/mes/ano'
            ],
        );
    }
}
