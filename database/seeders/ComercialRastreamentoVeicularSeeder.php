<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComercialRastreamentoVeicularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 200; $i++) {
            DB::table('comercial_rastreamento_veiculares')->insert([
                "planilha_id" => 19,
                "cliente" => Str::random(10),
                "data" => "2023-12-12",
                "id_contrato" => 0014,
                "placa" => "IMW-4444",
                "taxa_instalacao" => 79,
                "mensal" => 69,
                "comissao" => 38,
                "desconto_comissao" => 0
            ]);
        }
    }
}
