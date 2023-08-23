<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilPermissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 1, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 1, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 1, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 1, 'perfil_id' => 1, 'permissao_id' => 4]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 2, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 2, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 2, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 2, 'perfil_id' => 1, 'permissao_id' => 4]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 3, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 3, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 3, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 3, 'perfil_id' => 1, 'permissao_id' => 4]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 4, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 4, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 4, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 4, 'perfil_id' => 1, 'permissao_id' => 4]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 5, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 5, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 5, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 5, 'perfil_id' => 1, 'permissao_id' => 4]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 6, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 6, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 6, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 6, 'perfil_id' => 1, 'permissao_id' => 4]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 7, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 7, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 7, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 7, 'perfil_id' => 1, 'permissao_id' => 4]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 8, 'perfil_id' => 1, 'permissao_id' => 1]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 8, 'perfil_id' => 1, 'permissao_id' => 2]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 8, 'perfil_id' => 1, 'permissao_id' => 3]);
        DB::TABLE('perfil_permissao')->INSERT(['modulo_id' => 8, 'perfil_id' => 1, 'permissao_id' => 4]);
    }
}
