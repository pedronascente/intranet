<?php

namespace App\Models\Colaborador;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;

    private $paginacao;

    protected $fillable = [
        'nome',
    ];

    public function setPaginacao($paginacao)
    {     
      $this->paginacao = $paginacao;
    }

    public function getPaginacao()
    {     
      return  $this->paginacao;
    }

    public function getBaseOrderByIdDesc(){
       return $this->orderBy('id', 'desc')->paginate($this->getPaginacao());
    }

    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class);
    }

    public function salvar($nome){
        $this->nome = $nome;
        $this->save();
    }


    public function rules($method)
    {
        switch ($method) {
            case 'update':
               return ['nome' => 'required|max:190|min:2',];
            break;
            case 'store':
                return ['nome' => 'required|max:190|min:2|unique:bases,nome'];
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
}