<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuloPerfil extends Model
{
    protected $table = 'modulo_perfil'; 
   
    protected $fillable = [
        'perfil_id',
        'modulo_id',
    ];
}