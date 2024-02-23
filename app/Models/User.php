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
            'min:6', // deve ter pelo menos 6 caracteres
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
            'string'             => 'A senha deve ser uma string.',
            'min'                => 'A senha deve ter pelo menos :min caracteres.',
            'regex'              => 'A senha deve conter pelo menos uma letra minúscula, uma letra maiúscula, um dígito e um caractere especial.',
            'regex:/[a-z]/'      => 'A senha deve conter pelo menos uma letra minúscula.',
            'regex:/[A-Z]/'      => 'A senha deve conter pelo menos uma letra maiúscula.',
            'regex:/[0-9]/'      => 'A senha deve conter pelo menos um dígito.',
            'regex:/[@$!%*#?&]/' => 'A senha deve conter pelo menos um caractere especial.'
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
}