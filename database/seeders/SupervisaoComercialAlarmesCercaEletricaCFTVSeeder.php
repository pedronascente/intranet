<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupervisaoComercialAlarmesCercaEletricaCFTVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for ($i = 1; $i <= 200; $i++) {
            DB::table('supervisao_comercial_alarmes_cerca_eletrica_cftvs')->insert([
                "planilha_id"       => 6,
                "cliente"           => Str::random(10),
                "data"              => "2023-11-12",
                "servico_id"        => 3,
                "conta_pedido"      => "6666" . $i,
                "consultor"         => Str::random(10),
                "mensal"            => 33 + $i,
                "ins_vendas"        => 12 + $i,
                "comissao"          => 9 + $i,
                "desconto_comissao" => 0,
            ]);
        }
    }
}
