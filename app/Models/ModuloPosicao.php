<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloPosicao extends Model
{
    use HasFactory;
    protected $table = "modulo_posicoes";

    protected $fillable = ['nome'];

    public function modulo()
    {
        return $this->hasOne(Modulo::class);
    }
}