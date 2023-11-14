<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar 7 registros na tabela "meio"
        for ($i = 1; $i <= 7; $i++) {
            DB::table('meios')->insert([
                'nome' => "Meio {$i}",
            ]);
        }
    }
}
