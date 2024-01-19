<?php

namespace App\Models\Planilha;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\planilha\PlanilhaStatus;
use Illuminate\Database\Eloquent\Model;
use App\Models\Planilha\PlanilhaPeriodo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Planilha extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'matricula',
        'motivo_reprovacao',
        'ctps',
        'ano',
        'planilha_tipo_id',
        'planilha_periodo_id',
        'planilha_status_id',
    ];

    /**
     * Relacionamento com o modelo PlanilhaPeriodo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function periodo()
    {
        return $this->belongsTo(PlanilhaPeriodo::class, 'planilha_periodo_id', 'id');
    }

    /**
     * Relacionamento com o modelo PlanilhaTipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(\App\Models\planilha\Tipo\PlanilhaTipo::class, 'planilha_tipo_id', 'id');
    }

    /**
     * Relacionamento com o modelo PlanilhaStatus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(PlanilhaStatus::class, 'planilha_status_id', 'id');
    }

    /**
     * Relacionamento com o modelo Colaborador.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function colaborador()
    {
        return $this->belongsTo(\App\Models\Colaborador::class);
    }

    /**
     * Relacionamentos com diferentes tipos de planilhas de comissão.
     * Métodos do tipo HasMany.
     */
    public function comercialAlarmeCercaEletricaCFTV()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\ComercialAlarmeCercaEletricaCFTV::class);
    }

    public function comercialRastreamentoVeicular()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\ComercialRastreamentoVeicular::class);
    }

    public function entregaDeAlarmes()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\EntregaDeAlarmes::class);
    }

    public function portariaVirtual()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\PortariaVirtual::class);
    }

    public function reclamacaoDeCliente()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\ReclamacaoDeCliente::class);
    }

    public function supervisaoComercialAlarmesCercaEletricaCFTV()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\supervisaoComercialAlarmesCercaEletricaCFTV::class);
    }

    public function supervisaoComercialRastreamento()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\SupervisaoComercialRastreamento::class);
    }

    public function supervisaoTecnicaESACAlarmesCercaEletricaCFTV()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\SupervisaoTecnicaESACAlarmesCercaEletricaCFTV::class);
    }

    public function tecnicaAlarmesCercaEletricaCFTV()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\TecnicaAlarmesCercaEletricaCFTV::class);
    }

    public function tecnicaDeRastreamento()
    {
        return $this->hasMany(\App\Models\planilha\Tipo\TecnicaDeRastreamento::class);
    }

    /**
     * Regras de validação para a criação e atualização da planilha.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ctps'                => 'required|max:20',
            'matricula'           => 'required|max:20',
            'ano'                 => 'required|max:4',
            'planilha_periodo_id' => 'exists:planilha_periodos,id',
            'planilha_tipo_id'    => 'exists:planilha_tipos,id',
        ];
    }

    /**
     * Mensagens de feedback personalizadas para as regras de validação.
     *
     * @return array
     */
    public function feedback()
    {
        return  [
            'required'                   => 'Campo obrigatório.',
            'matricula.unique'           => 'Campo obrigatório.',
            'ano.required'               => 'Campo obrigatório.',
            'planilha_periodo_id.exists' => 'O Período informado não existe.',
            'planilha_tipo_id.exists'    => 'O Tipo de planilha informado não existe.',
        ];
    }

    /**
     * Regras de validação para reprovar a planilha.
     *
     * @return array
     */
    public function rules_reprovar()
    {
        return [
            'motivo_reprovacao' => 'required|max:300',
        ];
    }

    /**
     * Mensagens de feedback personalizadas para as regras de validação de reprovação.
     *
     * @return array
     */
    public function feedback_reprovar()
    {
        return  [
            'required'  => 'Campo obrigatório.',
        ];
    }

    public function relatorioDb(Request $request)
    {
        $filtro      = $request->input('filtro');
        $status      = $request->input('status');
        $dataInicial = $request->input('data_inicial');
        $dataFinal   = $request->input('data_final');
        $whereIn     = ($status == 'todos') ? [1, 2, 3, 4, 5] : [$status];

        $query = DB::table('planilhas')
        ->join('planilha_periodos', 'planilhas.planilha_periodo_id', '=', 'planilha_periodos.id')
        ->join('planilha_tipos', 'planilhas.planilha_tipo_id', '=', 'planilha_tipos.id')
        ->join('planilha_status', 'planilhas.planilha_status_id', '=', 'planilha_status.id')
        ->join('colaboradores', 'planilhas.colaborador_id', '=', 'colaboradores.id')
        ->leftJoin('comercial_alarme_cerca_eletrica_cftvs', 'planilhas.id', '=', 'comercial_alarme_cerca_eletrica_cftvs.planilha_id')
        ->leftJoin('comercial_rastreamento_veiculares', 'planilhas.id', '=', 'comercial_rastreamento_veiculares.planilha_id')
        ->leftJoin('servico_alarmes', 'comercial_alarme_cerca_eletrica_cftvs.servico_id', '=', 'servico_alarmes.id')
        ->where(function ($query) use ($filtro) {
            $query->where('comercial_alarme_cerca_eletrica_cftvs.cliente', 'like', '%' . $filtro . '%')
            ->orWhere('comercial_rastreamento_veiculares.cliente', 'like', '%' . $filtro . '%');
        })
            ->whereIn('planilhas.planilha_status_id', $whereIn);

        // Adiciona filtro de data para comercial_alarme_cerca_eletrica_cftvs, se fornecido
        if ($dataInicial && $dataFinal) {
            $query->where(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('comercial_alarme_cerca_eletrica_cftvs.data', [$dataInicial, $dataFinal]);
            });
        }

        // Adiciona filtro de data para comercial_rastreamento_veiculares, se fornecido
        if ($dataInicial && $dataFinal) {
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('comercial_rastreamento_veiculares.data', [$dataInicial, $dataFinal]);
            });
        }

        // Paginação
        $perPage = 100;
        $result = $query->select(
            'planilhas.*',
            'planilha_status.status',
            'planilha_tipos.nome as planilha',
            'planilha_periodos.nome as periodo',
            'colaboradores.nome as colaborador',
            'servico_alarmes.nome as servico',
            DB::raw('COALESCE(comercial_alarme_cerca_eletrica_cftvs.cliente, comercial_rastreamento_veiculares.cliente) as cliente'),
            DB::raw('COALESCE(comercial_alarme_cerca_eletrica_cftvs.data, comercial_rastreamento_veiculares.data) as data'),
            DB::raw('COALESCE(comercial_alarme_cerca_eletrica_cftvs.comissao, comercial_rastreamento_veiculares.comissao) as comissao'),
            DB::raw('COALESCE(comercial_alarme_cerca_eletrica_cftvs.conta_pedido) as conta_pedido')
        )->paginate($perPage);

        return $result;
    }




    /**
     * Exibe a página de listagem de planilhas com base em filtros.
     *
     * @param  \Illuminate\Http\Request  $request  Instância da requisição HTTP.
     * @param  string  $origem  Origem da listagem (conferir ou outra).
     * @return \Illuminate\Contracts\View\View
     */
    public function pesquisarPor(Request $request, $origem)
    {
        // Obtém os parâmetros da requisição
        $ano     = $request->input('ano');
        $filtro  = $request->input('filtro');
        $whereIn = $origem == 'conferir' ? [3, 5] : [2];

        // Inicia a consulta de planilhas com relacionamentos (colaborador, tipo, status)
        $query = $this->with('colaborador', 'tipo', 'status')->whereIn('planilha_status_id', $whereIn);

        // Adiciona condição para filtrar por ano, se fornecido
        if ($ano) {
            $query->where('ano', '=', $ano);
        }

        // Adiciona condição para pesquisa por termo, se fornecido
        if ($filtro) {
            $this->getTermoPesquisa($query, $filtro);
        }

        // Executa a consulta e obtém os resultados paginados
        return  $query->paginate(10);

    }


    /**
     * Aplica uma pesquisa por termo a uma consulta Eloquent.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  Instância da consulta Eloquent.
     * @param  string  $termoPesquisa  Termo de pesquisa.
     * @return void
     */
    private function getTermoPesquisa($query, $termoPesquisa)
    {
        // Adiciona condições à consulta para pesquisar por termo nos campos relevantes
        $query->where(function ($q) use ($termoPesquisa) {
            $q->whereHas('colaborador', function ($q) use ($termoPesquisa) {
                $q->where('nome', 'like', '%' . $termoPesquisa . '%')
                ->orWhere('sobrenome', 'like', '%' . $termoPesquisa . '%');
            })
                ->orWhereHas('tipo', function ($q) use ($termoPesquisa) {
                    $q->where('nome', 'like', '%' . $termoPesquisa . '%');
                })
                ->orWhereHas('periodo', function ($q) use ($termoPesquisa) {
                    $q->where('nome', 'like', '%' . $termoPesquisa . '%');
                });
        });
    }

}