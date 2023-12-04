<?php

namespace App\Models\Planilha;

use App\Models\planilha\PlanilhaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilha extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'ctps',
        'ano',
        'planilha_tipo_id',
        'planilha_periodo_id',
        'planilha_status_id',
    ];

    public function periodo()
    {
        return $this->belongsTo(PlanilhaPeriodo::class, 'planilha_periodo_id', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo(PlanilhaTipo::class, 'planilha_tipo_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(PlanilhaStatus::class, 'planilha_status_id', 'id');
    }

    public function colaborador()
    {
        return $this->belongsTo(\App\Models\Colaborador::class);
    }

    public function tecnicaDeRastreamento()
    {
        return $this->hasMany(TecnicaDeRastreamento::class);
    }

    public function comercialAlarmeCercaEletricaCFTV()
    {
        return $this->hasMany(ComercialAlarmeCercaEletricaCFTV::class);
    }

    public function comercialRastreamentoVeicular()
    {
        return $this->hasMany(ComercialRastreamentoVeicular::class);
    }

    public function rules()
    {
        return [
            'ctps' => 'required|max:20',
            'matricula' => 'required|max:20',
            'ano' => 'required|max:4',
            'planilha_periodo_id' => 'exists:planilha_periodos,id',
            'planilha_tipo_id' => 'exists:planilha_tipos,id',
        ];
    }

    public function feedback()
    {

        return  [
            'ctps.required' => 'Campo obrigatório.',
            'matricula.unique' => 'Campo obrigatório.',
            'ano.required' => 'Campo obrigatório.',
            'planilha_periodo_id.exists' => 'O Periodo informado não existe.',
            'planilha_tipo_id.exists' => 'O Tipo de planilha informado não existe.',
        ];
    }
}
