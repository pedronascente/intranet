<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloPermissaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modulo_permissao')->insert(['perfil_id' => 1,'modulo_id' => 1,  'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1,'modulo_id' => 1,  'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1,'modulo_id' => 1,  'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1,'modulo_id' => 1,  'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1,'modulo_id' => 1,  'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 2, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 2, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 2, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 2, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 2, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 3, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 3, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 3, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 3, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 3, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 4, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 4, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 4, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 4, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 4, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 5, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 5, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 5, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 5, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 5, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 6, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 6, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 6, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 6, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 6, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 7, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 7, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 7, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 7, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 7, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 8, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 8, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 8, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 8, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 8, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 9, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 9, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 9, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 9, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 9, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 10, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 10, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 10, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 10, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 10, 'permissao_id' => 5]);

        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 11, 'permissao_id' => 1]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 11, 'permissao_id' => 2]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 11, 'permissao_id' => 3]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 11, 'permissao_id' => 4]);
        DB::table('modulo_permissao')->insert(['perfil_id' => 1, 'modulo_id' => 11, 'permissao_id' => 5]);
    }
}