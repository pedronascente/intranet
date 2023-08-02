<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    protected $table = 'permissoes';

    public function modulos()
    {
        return $this->belongsToMany(Modulo::class);
    }

    public function perfils()
    {
        return $this->belongsToMany(
            Perfil::class,
            'modulo_perfil',
            'perfil_id',
            'id'
        );
    }
}
