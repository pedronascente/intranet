<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'imglogo',
    ];

    public function colaboradores()
    {
        return $this->hasMany(Colaborador::class);
    }

    public function rules($method)
    {
        $rules = [
            'nome' => 'required|max:190|min:5',
            'cnpj' => 'required|max:20|min:5',
        ];

        if ($method === 'store') {
            $rules['nome'] .= '|unique:empresas,nome';
            $rules['cnpj'] .= '|unique:empresas,cnpj';
            $rules['imglogo'] = [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'dimensions:width=179,height=53',
            ];
        }

        return $rules;
    }

    public function feedback()
    {
        return  [
            'required' => 'Campo obrigatório.',
            'nome.unique' => 'Esta empresa já está sendo utilizado.',
            'cnpj.unique' => 'Este CNPJ já está sendo utilizado.',
            'imglogo.required' => 'Campo de imagem obrigatório.',
            'imglogo.image' => 'O arquivo deve ser uma imagem.',
            'imglogo.mimes' => 'A imagem deve estar nos formatos: jpg, jpeg, png.',
            'imglogo.dimensions' => 'A imagem deve ter largura de 179px e altura de 53px.',
        ];
    }
}
