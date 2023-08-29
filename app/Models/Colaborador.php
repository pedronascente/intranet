<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    protected $table = "colaboradores";

    protected $fillable = [
        'nome',
        'sobrenome',
        'empresa_id',
        'cargo_id',
        'user_id',
        'base_id',
        'email',
        'rg',
        'cpf',
        'cnpj',
        'foto',
        'ramal',
    ];

    public function empresa()
    {
        return $this->BelongsTo(Empresa::class);
    }

    public function cargo()
    {
        return $this->BelongsTo(Cargo::class);
    }

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function base()
    {
        return $this->BelongsTo(Base::class);
    }
}
