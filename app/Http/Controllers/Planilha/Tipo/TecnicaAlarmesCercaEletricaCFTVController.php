<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planilha\Planilha;
use App\Models\Planilha\Tipo\ServicoAlarme;
use App\Models\Planilha\Tipo\PlanilhaTipo;
use App\Models\planilha\Tipo\TecnicaAlarmesCercaEletricaCFTV;

class TecnicaAlarmesCercaEletricaCFTVController extends Controller
{
    private $titulo;
    private $planilhaTipo;
    private $tecnicaAlarmesCercaEletricaCFTV;

    public function __construct(TecnicaAlarmesCercaEletricaCFTV $tecnicaAlarmesCercaEletricaCFTV)
    {
        $this->titulo = "Técnica Alarmes / Cerca Elétrica / CFTV";
        $this->planilhaTipo = new PlanilhaTipo();
        $this->tecnicaAlarmesCercaEletricaCFTV = $tecnicaAlarmesCercaEletricaCFTV;
    }

    public function store(Request $request)
    {
        $request->validate($this->tecnicaAlarmesCercaEletricaCFTV->rules(), $this->tecnicaAlarmesCercaEletricaCFTV->feedback());
        $objetoModel = $this->tecnicaAlarmesCercaEletricaCFTV;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->servico()->associate(ServicoAlarme::find($request->servico_id));
        $objetoModel->data              = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->numero_os         = $request->numero_os;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $request->planilha_id)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao = $this->tecnicaAlarmesCercaEletricaCFTV->findOrFail($id);
        $servico_alarme = ServicoAlarme::all();
        return view('planilha.tipo.tecnicaAlarmesCercaEletricaCFTV.edit', [
            'titulo' => $this->titulo,
            'comissao' => $comissao,
            'servico_alarme' => $servico_alarme,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->tecnicaAlarmesCercaEletricaCFTV->rules(), $this->tecnicaAlarmesCercaEletricaCFTV->feedback());
        $objetoModel = $this->tecnicaAlarmesCercaEletricaCFTV->findOrFail($id);
        $objetoModel->servico()->associate(ServicoAlarme::find($request->servico_id));
        $objetoModel->data              = $this->planilhaTipo->formatarData($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->numero_os         = $request->numero_os;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->save();
        return redirect()
            ->route('tecnica-ace-cftv.edit', $id)
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->tecnicaAlarmesCercaEletricaCFTV->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->route('planilha-colaborador-tipo.index', $objetoModel->planilha_id)
            ->with('status', "Registro excluido com sucesso!");
    }
}
