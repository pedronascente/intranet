<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*
    public function modulos()
    {
        return $this->belongsToMany(Modulo::class, 'grupo_modulo', 'modulo_id', 'id');
    }
    */
}
