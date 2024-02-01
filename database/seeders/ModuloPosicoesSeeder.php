<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloPosicoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modulo_posicoes')->insert([
            'nome' => 'Lateral Esquerdo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modulo_posicoes')->insert([
            'nome' => 'Configurações',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}