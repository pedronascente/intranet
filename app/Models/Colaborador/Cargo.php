<?php

namespace App\Models\Colaborador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class);
    }

    public function rules($method)
    {
        switch ($method) {
            case 'update':
                return ['nome' => 'required|max:190|min:2'];
                break;
            case 'store':
                return ['nome' => 'required|max:190|min:2|unique:cargos,nome'];
                break;
        }
    }

    public function feedback()
    {
        return [
            'nome.required' => 'Campo obrigatório.',
            'nome.unique' => 'Este nome já está sendo utilizado.',
        ];
    }

    public function getCargo($filtro = null)
    {
        $query = $this->orderBy('id', 'desc');
        if ($filtro) {
            $query->where('nome', 'like', '%' . $filtro . '%');
        }
        return $query->paginate(10);
    }

    public function setPaginacao($paginacao)
    {
        $this->paginacao = $paginacao;
    }

    public function getPaginacao()
    {
        return  $this->paginacao;
    }

    public function getCargoOrderByIdDesc()
    {
        return $this->orderBy('id', 'desc')->paginate($this->getPaginacao());
    }

}