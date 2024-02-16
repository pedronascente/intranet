<?php

namespace App\Http\Controllers\Comissao\Planilhas;

use Illuminate\Http\Request;
use App\Models\Comissao\Planilha;
use App\Models\Comissao\Tipo\Meio;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\Comissao\Tipo\ServicoAlarme;
use App\Models\Comissao\Tipo\ComercialAlarmeCercaEletricaCFTV;
class ComercialAlarmeCercaEletricaCFTVController extends Controller
{
    private $titulo;
    private $comercialAlarmeCercaEletricaCFTV;

    public function __construct(ComercialAlarmeCercaEletricaCFTV $comercialAlarmeCercaEletricaCFTV)
    {
        $this->titulo                           = "Comercial Alarme / Cerca Elétrica / CFTV";
        $this->comercialAlarmeCercaEletricaCFTV = $comercialAlarmeCercaEletricaCFTV;
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
        $request->validate($this->comercialAlarmeCercaEletricaCFTV->rules(), $this->comercialAlarmeCercaEletricaCFTV->feedback());
        if($this->comercialAlarmeCercaEletricaCFTV->validarComissaoDuplicada($request)>=1){
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->comercialAlarmeCercaEletricaCFTV;
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->planilha()->associate(Planilha::find($request->planilha_id));
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->meio()->associate(Meio::findOrFail($request->meio_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $comissao       = $this->comercialAlarmeCercaEletricaCFTV->findOrFail($id);
        $servico_alarme = ServicoAlarme::all();
        $meios          = Meio::all();
        return view('planilha.tipo.comercialAlarmeCercaEletricaCFTV.colaborador.edit', [
            'titulo'         => $this->titulo,
            'comissao'       => $comissao,
            'servico_alarme' => $servico_alarme,
            'meios'          => $meios,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->comercialAlarmeCercaEletricaCFTV->rules(), $this->comercialAlarmeCercaEletricaCFTV->feedback());
        if ($this->comercialAlarmeCercaEletricaCFTV->validarComissaoDuplicada($request) >= 1) {
            return redirect()
                ->back()
                ->with('warning', "Atenção : Duplicar comissão não é permitido!");
        }
        $objetoModel                    = $this->comercialAlarmeCercaEletricaCFTV->findOrFail($id);       
        $objetoModel->data              = CaniveteHelp::formatarDataAnoMesDia($request->data);
        $objetoModel->cliente           = $request->cliente;
        $objetoModel->conta_pedido      = $request->conta_pedido;
        $objetoModel->ins_vendas        = $request->ins_vendas;
        $objetoModel->mensal            = $request->mensal;
        $objetoModel->comissao          = $request->comissao;
        $objetoModel->desconto_comissao = $request->desconto_comissao;
        $objetoModel->servico()->associate(ServicoAlarme::findOrFail($request->servico_id));
        $objetoModel->meio()->associate(Meio::findOrFail($request->meio_id));
        $objetoModel->save();
        return redirect()
            ->back()
            ->with('status', 'Registro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $objetoModel = $this->comercialAlarmeCercaEletricaCFTV->findOrFail($id);
        $objetoModel->delete();
        return redirect()
            ->back()
            ->with('status', "Registrado Excluido com sucesso!");
    }   
}