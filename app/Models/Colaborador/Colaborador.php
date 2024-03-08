<?php

namespace App\Models\Colaborador;

use App\Models\User;
use App\Models\Comissao\Planilha;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function usuario()
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
        return $this->hasMany(Planilha::class);
    }

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
        if ($request->_method != "PUT") {
            $validar['numero_matricula'] = 'required|integer|min:1|max:9999999999|unique:colaboradores,numero_matricula';
        }     
        $validar['rg']               = 'required|max:15';
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

    public function getColaborador($filtro = null)
    {
        $query = $this->orderBy('id', 'desc');
        if ($filtro) {
            $query->where('nome', 'like', '%' . $filtro . '%');
            $query->orWhere('numero_matricula', 'like', '%' . $filtro . '%');
            $query->orWhere('rg', 'like', '%' . $filtro . '%');
            $query->orWhere('cpf', 'like', '%' . $filtro . '%');
            $query->orWhere('email', 'like', '%' . $filtro . '%');
        }

         //$sql = $query->toSql(); // Aqui você obtém o SQL gerado
         //dd($sql); // Aqui você exibe o SQL gerado

        return $query->paginate(10);
    }

}

