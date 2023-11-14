<?php

namespace App\Models\Comissao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilha extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'status',
        'ano',

    ];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function tipoPlanilha()
    {
        return $this->belongsTo(TipoPlanilha::class);
    }

    public function colaborador()
    {
        return $this->belongsTo(\App\Models\Colaborador::class);
    }

    public function TecnicaDeRastreamento()
    {
        return $this->hasMany(TecnicaDeRastreamento::class);
    }

    public function ComercialAlarmeCercaEletricaCFTV()
    {
        return $this->hasMany(ComercialAlarmeCercaEletricaCFTV::class);
    }
}
