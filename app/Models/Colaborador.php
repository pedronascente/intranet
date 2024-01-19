<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;

    /**
     * Define a tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = "colaboradores";

    /**
     * Define os campos que podem ser preenchidos em massa.
     *
     * @var array
     */
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

    /**
     * Relacionamento: Colaborador pertence a uma Empresa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relacionamento: Colaborador pertence a um Cargo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    /**
     * Relacionamento: Colaborador tem um User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Relacionamento: Colaborador pertence a uma Base.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function base()
    {
        return $this->belongsTo(Base::class);
    }

    /**
     * Relacionamento: Colaborador tem muitas Planilhas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planilhas()
    {
        return $this->hasMany(\App\Models\planilha\Planilha::class);
    }

    /**
     * Define as regras de validação para os campos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colaborador|null  $colaborador
     * @return array
     */
    public function rules($request, $colaborador = null)
    {
        // ... lógica para definir regras de validação ...
        if ($colaborador) {
            if ($request->email != $colaborador->email) {
                $validar['email'] = 'required|email|unique:colaboradores,email';
            }
            if ($request->cpf != $colaborador->cpf) {
                $validar['cpf'] = 'required|max:14|unique:colaboradores,cpf';
            }
        } else {

            $validar['email'] = 'required|email|unique:colaboradores,email';
            $validar['cpf'] = 'required|max:14|unique:colaboradores,cpf';
        }

        if (isset($request->user_id)) {
            $validar['user_id'] = 'required|max:4|unique:colaboradores,user_id';
        }


        $validar['nome']       = 'required|max:191|min:2';
        $validar['ramal']      = 'required|max:4|min:2';
        $validar['sobrenome']  = 'required|max:191|min:5';
        $validar['rg']         = 'required|max:15';
        $validar['base_id']    = 'required';
        $validar['empresa_id'] = 'required';
        $validar['cargo_id']   = 'required';
        $validar['foto']       = [
            'nullable',
            'image',
            'max:1024'
        ];


        return $validar;
    }

    /**
     * Define as mensagens de feedback para as regras de validação.
     *
     * @return array
     */
    public function feedback()
    {
        return [
            'required' => 'Campo obrigatório.',
        ];
    }


}
