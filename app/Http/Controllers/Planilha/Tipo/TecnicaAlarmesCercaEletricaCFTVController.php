<?php

namespace App\Http\Controllers\Planilha\Tipo;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Planilha\Tipo\ServicoAlarme;
use App\Models\planilha\Tipo\TecnicaAlarmesCercaEletricaCFTV;

class TecnicaAlarmesCercaEletricaCFTVController extends Controller
{
    private $titulo;
    private $tecnicaAlarmesCercaEletricaCFTV;

    public function __construct(TecnicaAlarmesCercaEletricaCFTV $tecnicaAlarmesCercaEletricaCFTV)
    {
        $this->titulo                          = "Técnica Alarmes / Cerca Elétrica / CFTV";
        $this->tecnicaAlarmesCercaEletricaCFTV = $tecnicaAlarmesCercaEletricaCFTV;
    }

    public function index()
    {
        return redirect()
            ->back();
    }

    public function show($id)
    {
        return redirect()
            ->back();
    }
    
    public function store(Request $request)
    {
        $request->validate($this->tecnicaAlarmesCercaEletricaCFTV->rules(), $this->tecnicaAlarmesCercaEletricaCFTV->feedback());
        if ($this->tecnicaAlarmesCercaEletricaCFTV->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
       
        $objetoModel                    = $this->tecnicaAlarmesCercaEletricaCFTV;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->numero_os         = $request->numero_os;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->servico()->associate(ServicoAlarme::find($request->servico_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao       = $this->tecnicaAlarmesCercaEletricaCFTV->findOrFail($id);
        $servico_alarme = ServicoAlarme::all();
        return view('planilha.tipo.tecnicaAlarmesCercaEletricaCFTV.colaborador.edit', [
            'titulo'         => $this->titulo,
            'comissao'       => $comissao,
            'servico_alarme' => $servico_alarme,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->tecnicaAlarmesCercaEletricaCFTV->rules(), $this->tecnicaAlarmesCercaEletricaCFTV->feedback());
        if ($this->tecnicaAlarmesCercaEletricaCFTV->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->tecnicaAlarmesCercaEletricaCFTV->findOrFail($id);
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->numero_os         = $request->numero_os;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->servico()->associate(ServicoAlarme::find($request->servico_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->tecnicaAlarmesCercaEletricaCFTV->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registro excluido com sucesso!");
    }
}