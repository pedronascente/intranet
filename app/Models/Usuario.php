<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne([Tipos::class]);
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
