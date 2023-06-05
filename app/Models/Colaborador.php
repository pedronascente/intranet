<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = "colaboradores";

    public function empresa()
    {
        return $this->BelongsTo(Empresa::class);
    }

    public function cargo()
    {
        return $this->BelongsTo(Cargo::class);
    }
}
