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
        'nuemro_matricula',
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
        return $this->hasMany(\App\Models\Comissao\Planilha::class);
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

        $validar['nome']             = 'required|min:2|max:191';
        $validar['ramal']            = 'required|integer|min:1|max:9999';
        $validar['sobrenome']        = 'required|min:5|max:191';
        $validar['rg']               = 'required|max:15';
        $validar['numero_matricula'] = 'required|integer|min:1|max:9999999999|unique:colaboradores,numero_matricula';
        $validar['base_id']          = 'required';
        $validar['empresa_id']       = 'required';
        $validar['cargo_id']         = 'required';
        $validar['foto']             = [
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
