<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissaoSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissoes')->insert(['nome' => 'Editar']);
        DB::table('permissoes')->insert(['nome' => 'Excluir']);
        DB::table('permissoes')->insert(['nome' => 'Criar']);
        DB::table('permissoes')->insert(['nome' => 'Visualizar']);
    }
}
