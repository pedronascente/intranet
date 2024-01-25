<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloPerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 1]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 2]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 3]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 4]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 5]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 6]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 7]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 8]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 9]);
        DB::table('modulo_perfil')->insert(['perfil_id' => 1, 'modulo_id' => 10]);
    }
}
