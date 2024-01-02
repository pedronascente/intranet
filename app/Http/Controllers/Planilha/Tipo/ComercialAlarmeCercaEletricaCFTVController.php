<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\Meio;
use App\Models\Planilha\Tipo\ServicoAlarme;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\Planilha\Tipo\ComercialAlarmeCercaEletricaCFTV;

class ComercialAlarmeCercaEletricaCFTVController extends Controller
{
    private $titulo;
    private $planilhaTipo;
    private $comercialAlarmeCercaEletricaCFTV;

    public function __construct(ComercialAlarmeCercaEletricaCFTV $comercialAlarmeCercaEletricaCFTV)
    {
        $this->titulo                           = "Comercial Alarme / Cerca Elétrica / CFTV";
        $this->planilhaTipo                     = new PlanilhaTipo();
        $this->comercialAlarmeCercaEletricaCFTV = $comercialAlarmeCercaEletricaCFTV;
    }

    public function store(Request $request)
    {
        $request->validate($this->comercialAlarmeCercaEletricaCFTV->rules(), $this->comercialAlarmeCercaEletricaCFTV->feedback());
        $objetoModel = $this->comercialAlarmeCercaEletricaCFTV;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->meio()->associate(Meio::findOrFail($request->meio_id));
        $objetoModel->data              = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao       = $this->comercialAlarmeCercaEletricaCFTV->findOrFail($id);
        $servico_alarme = ServicoAlarme::all();
        $meios          = Meio::all();
        return view('planilha.tipo.comercialAlarmeCercaEletricaCFTV.edit', [
            'titulo'         => $this->titulo,
            'comissao'       => $comissao,
            'servico_alarme' => $servico_alarme,
            'meios'          => $meios,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->comercialAlarmeCercaEletricaCFTV->rules(), $this->comercialAlarmeCercaEletricaCFTV->feedback());
        $objetoModel = $this->comercialAlarmeCercaEletricaCFTV->findOrFail($id);
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->meio()->associate(Meio::findOrFail($request->meio_id));
        $objetoModel->data              = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('cace-cftv.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->comercialAlarmeCercaEletricaCFTV->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registrado Excluido com sucesso!");
    }
}
