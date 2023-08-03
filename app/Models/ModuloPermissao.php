<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModuloPermissao extends Model
{
    use HasFactory;

    public static function deletePermissoes($id)
    {
        DB::table('modulo_permissao')->where('perfil_id', $id)->delete();
    }
}
