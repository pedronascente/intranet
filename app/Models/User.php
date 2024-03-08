<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Colaborador\Colaborador;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'perfil_id',
        'colaborador_id',
        'qtdToken'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function getStatus($id)
    {
        $status =  DB::table('users')->select('status')->where('id', $id)->first();
        if ($status->status == 'on') {
            $retornar = 'Ativo';
        } else {
            $retornar = 'Inativo';
        }
        return $retornar;
    }

    /**
     * Responsável por validar formulário de usuário
     *
     * @param Request $request
     * @param string $tipo
     * @return void
     */
    public function validarFormulario( $request, $method)
    {
        switch($method) {
            case 'post':
                $rules = [
                    'colaborador_id' => ['required', 'integer', 'unique:users', function ($attribute, $value, $fail) {
                        if (!Colaborador::where('id', $value)->exists()) {
                            $fail('O ID do colaborador fornecido não existe.');
                        }
                    }],
                    'qtdToken' => ['required', 'string'],
                    'status' => ['required', 'string'],
                    'perfil' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                    'password_confirmation' => ['required'],
                    'password' => $this->getRegraPassword(),
                ];

                $feedback = $this->feedback();
                $request->validate($rules, $feedback);
            break;
            case 'put':  
                $rules =  [
                    'status' => ['required', 'string'],
                    'perfil' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                ];
                if (!is_null($request->password) || !is_null($request->password_confirmation)) {
                    $rules = array_merge($rules, [
                        'password_confirmation' => ['required'],
                        'password' => $this->getRegraPassword(),
                    ]);
                }
                $request->validate($rules);
            break;
            case 'resetPassword':
                $request->validate([
                    'password_confirmation' => ['required'],
                    'password' => $this->getRegraPassword(),
                ]);
            break;
        }
    }

    public function getRegraPassword()
    {
        return [
            'required',
            'confirmed',
            'string',
            'min:10', // deve ter pelo menos 10 caracteres
            'max:25', // deve ter max  25 caracteres
            'regex:/[a-z]/', // deve conter pelo menos uma letra minúscula
            'regex:/[A-Z]/', // deve conter pelo menos uma letra maiúscula
            'regex:/[0-9]/', // deve conter pelo menos um dígito
            'regex:/[@$!%*#?&]/', // deve conter um caractere especial
        ];
    }

    public function feedback()
    {
        return [
            'unique'             => 'Este id já está sendo usado.',
            'required'           => 'Campo obrigatorio.',
            'confirmed'          => 'A confirmação de senha não corresponde.',
            'string'             => 'Senha deve ser uma string.',
            'min'                => 'Senha deve ter entre 6 e 25 caracteres.',
            'max'                => 'Senha deve ter entre 6 e 25 caracteres.',
            'regex'              => 'Senha deve conter pelo menos 1 letra minúscula, 1 letra maiúscula, 1 dígito e 1 caractere especial.',
            'regex:/[a-z]/'      => 'Senha deve conter pelo menos 1 letra minúscula.',
            'regex:/[A-Z]/'      => 'Senha deve conter pelo menos 1 letra maiúscula.',
            'regex:/[0-9]/'      => 'Senha deve conter pelo menos 1 dígito.',
            'regex:/[@$!%*#?&]/' => 'Senha deve conter pelo menos 1 caractere especial.'
        ];
    }

    public function  rulesLogin()
    {
        return  [
            'name' => 'required',
            'password' => 'required',
        ];
    }

    public function  feedbackLogin()
    {
        return  [
            'name.required' => 'O campo usuario é obrigatório!',
            'password.required' => 'O campo senha é obrigatório!',
        ];
    }

    public function getUsuarioESeuPerfil($filtro = null)
    {
        $query = $this->with(['perfil', 'colaborador.empresa'])->orderByDesc('id');

        if ($filtro) {
            $query->where(function ($query) use ($filtro) {
                $query->where('name', 'like', '%' . $filtro . '%')
                ->orWhereHas('colaborador', function ($query) use ($filtro) {
                    $query->where('nome', 'like', '%' . $filtro . '%')
                    ->orWhere('name', 'like', '%' . $filtro . '%')
                    ->whereHas('empresa', function ($query) use ($filtro) {
                        $query->where('nome', 'like', '%' . $filtro . '%');
                    });
                });
            });
        }

        //$sql = $query->toSql(); // Aqui você obtém o SQL gerado
        //dd($sql); // Aqui você exibe o SQL gerado
        return $query->paginate(10);
    }
}