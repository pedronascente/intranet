<?php

namespace App\Models\Planilha;

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

    public function getRelatorio($status, $filtro, $dataInicial, $dataFinal)
    {
        $query = DB::table('planilhas')
        ->join('planilha_periodos', 'planilhas.planilha_periodo_id', '=', 'planilha_periodos.id')
        ->join('planilha_tipos', 'planilhas.planilha_tipo_id', '=', 'planilha_tipos.id')
        ->join('planilha_status', 'planilhas.planilha_status_id', '=', 'planilha_status.id')
        ->join('colaboradores', 'planilhas.colaborador_id', '=', 'colaboradores.id')
        ->leftJoin('comercial_alarme_cerca_eletrica_cftvs', 'planilhas.id', '=', 'comercial_alarme_cerca_eletrica_cftvs.planilha_id')
        ->leftJoin('comercial_rastreamento_veiculares', 'planilhas.id', '=', 'comercial_rastreamento_veiculares.planilha_id')
        ->leftJoin('entrega_alarmes', 'planilhas.id', '=', 'entrega_alarmes.planilha_id')
        ->leftJoin('portaria_virtuais', 'planilhas.id', '=', 'portaria_virtuais.planilha_id')
        ->leftJoin('reclamacao_de_clientes', 'planilhas.id', '=', 'reclamacao_de_clientes.planilha_id')
        ->leftJoin('supervisao_comercial_alarmes_cerca_eletrica_cftvs', 'planilhas.id', '=', 'supervisao_comercial_alarmes_cerca_eletrica_cftvs.planilha_id')
        ->leftJoin('supervisao_comercial_rastreamentos', 'planilhas.id', '=', 'supervisao_comercial_rastreamentos.planilha_id')
        ->leftJoin('supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs', 'planilhas.id', '=', 'supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs.planilha_id')
        ->leftJoin('tecnica_alarmes_cerca_eletrica_cftvs', 'planilhas.id', '=', 'tecnica_alarmes_cerca_eletrica_cftvs.planilha_id')
        ->leftJoin('tecnica_de_rastreamentos', 'planilhas.id', '=', 'tecnica_de_rastreamentos.planilha_id')

        ->leftJoin('servico_alarmes', 'supervisao_comercial_alarmes_cerca_eletrica_cftvs.servico_id', '=', 'servico_alarmes.id')
        ->leftJoin('servico_alarmes as servico_alarmes1', 'comercial_alarme_cerca_eletrica_cftvs.servico_id', '=', 'servico_alarmes1.id')
        ->leftJoin('servico_alarmes as servico_alarmes2', 'tecnica_alarmes_cerca_eletrica_cftvs.servico_id', '=', 'servico_alarmes2.id')

        ->where(function ($query) use ($filtro) {
            $query->where('comercial_alarme_cerca_eletrica_cftvs.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('comercial_rastreamento_veiculares.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('comercial_rastreamento_veiculares.placa', 'like', '%' . $filtro . '%')

                ->orWhere('entrega_alarmes.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('portaria_virtuais.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('reclamacao_de_clientes.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('supervisao_comercial_alarmes_cerca_eletrica_cftvs.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('supervisao_comercial_rastreamentos.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs.cliente', 'like', '%' . $filtro . '%')

                ->orWhere('tecnica_de_rastreamentos.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('tecnica_de_rastreamentos.placa', 'like', '%' . $filtro . '%')
              
                ->orWhere('servico_alarmes.nome', 'like', '%' . $filtro . '%')
                ->orWhere('servico_alarmes1.nome', 'like', '%' . $filtro . '%')
                ->orWhere('servico_alarmes2.nome', 'like', '%' . $filtro . '%')

                ->orWhere('tecnica_alarmes_cerca_eletrica_cftvs.cliente', 'like', '%' . $filtro . '%')
                ->orWhere('tecnica_alarmes_cerca_eletrica_cftvs.numero_os', 'like', '%' . $filtro . '%')
                ->orWhere('planilha_tipos.nome', 'like', '%' . $filtro . '%');
        });

        if (($status == 6)) {
            $query->whereIn('planilhas.planilha_status_id', [1, 2, 3, 4, 5]);
        } else {
            $query->where('planilhas.planilha_status_id', $status);
        }

        if ($dataInicial && $dataFinal) {
            $query->where(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('comercial_alarme_cerca_eletrica_cftvs.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('comercial_rastreamento_veiculares.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('entrega_alarmes.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('portaria_virtuais.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('reclamacao_de_clientes.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('supervisao_comercial_alarmes_cerca_eletrica_cftvs.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('supervisao_comercial_rastreamentos.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('tecnica_alarmes_cerca_eletrica_cftvs.data', [$dataInicial, $dataFinal]);
            });
            $query->orWhere(function ($q) use ($dataInicial, $dataFinal) {
                $q->whereBetween('tecnica_de_rastreamentos.data', [$dataInicial, $dataFinal]);
            });
        }

        $query->select(
            'planilhas.*',
            'planilha_status.status',
            'planilha_tipos.nome as planilha',
            'planilha_periodos.nome as periodo',
            'colaboradores.nome as colaborador',
            'tecnica_alarmes_cerca_eletrica_cftvs.numero_os',
            DB::raw('COALESCE(
                comercial_rastreamento_veiculares.placa,
                tecnica_de_rastreamentos.placa
                ) as placa'),
            DB::raw('COALESCE(
                servico_alarmes.nome,
                servico_alarmes1.nome,
                servico_alarmes2.nome
                ) as servico'),
            DB::raw('COALESCE(
                comercial_alarme_cerca_eletrica_cftvs.cliente,
                comercial_rastreamento_veiculares.cliente,
                entrega_alarmes.cliente,
                portaria_virtuais.cliente,
                reclamacao_de_clientes.cliente,
                supervisao_comercial_alarmes_cerca_eletrica_cftvs.cliente,
                supervisao_comercial_rastreamentos.cliente,
                supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs.cliente,
                tecnica_alarmes_cerca_eletrica_cftvs.cliente,
                tecnica_de_rastreamentos.cliente
                ) as cliente'),
            DB::raw('COALESCE(
                comercial_alarme_cerca_eletrica_cftvs.data,
                comercial_rastreamento_veiculares.data,
                entrega_alarmes.data,
                portaria_virtuais.data,
                reclamacao_de_clientes.data,
                supervisao_comercial_alarmes_cerca_eletrica_cftvs.data,
                supervisao_comercial_rastreamentos.data,
                supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs.data,
                tecnica_alarmes_cerca_eletrica_cftvs.data,
                tecnica_de_rastreamentos.data
                ) as data'),
            DB::raw('COALESCE(
                comercial_alarme_cerca_eletrica_cftvs.comissao,
                comercial_rastreamento_veiculares.comissao,
                entrega_alarmes.comissao,
                portaria_virtuais.comissao,
                reclamacao_de_clientes.comissao,
                supervisao_comercial_alarmes_cerca_eletrica_cftvs.comissao,
                supervisao_comercial_rastreamentos.comissao,
                supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs.comissao,
                tecnica_alarmes_cerca_eletrica_cftvs.comissao,
                tecnica_de_rastreamentos.comissao
                ) as comissao'),
            DB::raw('COALESCE(
                comercial_alarme_cerca_eletrica_cftvs.conta_pedido,
                entrega_alarmes.conta_pedido,
                portaria_virtuais.conta_pedido,
                reclamacao_de_clientes.conta_pedido,
                supervisao_comercial_alarmes_cerca_eletrica_cftvs.conta_pedido,
                supervisao_comercial_rastreamentos.conta_pedido,
                supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs.conta_pedido,
                tecnica_alarmes_cerca_eletrica_cftvs.conta_pedido,
                tecnica_de_rastreamentos.conta_pedido
                ) as conta_pedido')
        );

       return  $query->paginate(10)->appends([
            'filtro'       => $filtro,
            'status'       => $status,
            'data_inicial' => $dataInicial,
            'data_final'   => $dataFinal,
        ]);
        
    }

    public function getPlanilha($request, $arrayPlanilhaStatusId)
    {

        $ano    = $request->query('ano');
        $filtro = $request->query('filtro');

        //$whereIn = $origem == 'conferir' ? [3, 5] : [2];
        $whereIn = $arrayPlanilhaStatusId;

        // Inicia a consulta de planilhas com relacionamentos (colaborador, tipo, status)
        $query = $this->with('colaborador', 'tipo', 'status')->whereIn('planilha_status_id', $whereIn);
        if ($ano) {
            $query->where('ano', '=', $ano);
        }
        // Adiciona condição para pesquisa por termo, se fornecido
        if ($filtro) {
            $this->getTermoPesquisa($query, $filtro);
        }
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