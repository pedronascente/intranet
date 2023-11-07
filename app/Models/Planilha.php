<?php

namespace App\Models;

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
        return $this->belongsTo(Colaborador::class);
    }

    public function comissaoTecnicaDeRastreamento()
    {
        return $this->hasMany(TecnicaDeRastreamento::class);
    }
}
