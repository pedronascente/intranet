<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = ['ativo', 'usuario', 'password', 'email', 'colaborador_id', 'grupo_id'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    //pertense a
    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }
}
