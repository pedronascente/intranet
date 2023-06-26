<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    /*
    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_modulo');
    }
   */
}
