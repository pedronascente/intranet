<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloCategoriasSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulo_categorias')->insert([
            'nome' => 'Comissão',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modulo_categorias')->insert([
            'nome' => 'Colaborador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('modulo_categorias')->insert([
            'nome' => 'Geral',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('modulo_categorias')->insert([
            'nome' => 'Perfil',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
