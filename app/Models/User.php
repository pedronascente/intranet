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
        'perfil_id'
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
        return $this->hasOne(Colaborador::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function cartao()
    {
        return $this->hasOne(Cartao::class,  'user_id', 'id');
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
}
