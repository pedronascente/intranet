<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'rota',
        'descricao',
    ];

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class);
    }
}
