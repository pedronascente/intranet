<?php

namespace App\Models\Planilha;

use App\Models\planilha\PlanilhaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            'required'              => 'Campo obrigatório.',
            'matricula.unique'      => 'Campo obrigatório.',
            'ano.required'          => 'Campo obrigatório.',
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
}
