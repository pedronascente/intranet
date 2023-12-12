<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupervisaoComercialRastreamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for ($i = 1; $i <= 200; $i++) {
            DB::table('supervisao_comercial_rastreamentos')->insert([
                "planilha_id"        => 7,
                "cliente"            => Str::random(10),
                "data"               => "2023-11-12",
                "conta_pedido"       => 78 + $i,
                "total_rastreadores" => 1,
                "comissao"           =>  22 + $i,
                "desconto_comissao"  => 0,
            ]);
        }
    }
}
