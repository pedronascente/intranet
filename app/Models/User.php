<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
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

    /*
    public function cartao()
    {
        return $this->hasOne(Cartao::class,  'user_id', 'id');
    }

    */

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function getStatus($id)
    {
        $status =  DB::table('users')
            ->select('status')->where('id', $id)
            ->first();

        if ($status->status == 'on') {
            $retornar = 'Ativo';
        } else {
            $retornar = 'Inativo';
        }
        return $retornar;
    }

    /**
     * Responsavel por validar formulario
     *
     * @param Request $request
     * @param [object] $usuario
     * @return void
     */
    public function validarFormulario($request, $tipo)
    {
        switch ($tipo) {
            case 'store':
                $request->validate([
                    'colaborador_id' => ['required', 'integer'],
                    'qtdToken' => ['required', 'string'],
                    'status' => ['required', 'string'],
                    'perfil' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                    'password_confirmation' => ['required'],
                    'password' => $this->getRegraPassword(),
                ]);
                break;
            case 'update':
                $regras =  [
                    'colaborador_id' => ['required', 'integer'],
                    'status' => ['required', 'string'],
                    'perfil' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                ];
                if (!is_null($request->password) || !is_null($request->password_confirmation)) {
                    $regras = array_merge($regras, [
                        'password_confirmation' => ['required'],
                        'password' => $this->getRegraPassword(),
                    ]);
                }
                $request->validate($regras);
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
            'min:6',              // deve ter pelo menos 6 caracteres
            'regex:/[a-z]/',      // deve conter pelo menos uma letra minúscula
            'regex:/[A-Z]/',      // deve conter pelo menos uma letra maiúscula
            'regex:/[0-9]/',      // deve conter pelo menos um dígito
            'regex:/[@$!%*#?&]/', // deve conter um caractere especial
        ];
    }
}
