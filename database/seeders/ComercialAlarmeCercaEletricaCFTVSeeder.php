<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComercialAlarmeCercaEletricaCFTVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 200; $i++) {
            DB::table('comercial_alarme_cerca_eletrica_cftvs')->insert([
                "planilha_id" => 14,
                "cliente" => Str::random(10),
                "data" => "2023-12-12",
                "servico_id" => 5,
                "conta_pedido" => "458888",
                "meio_id" => 2,
                "ins_vendas" => 56,
                "mensal" => 69,
                "comissao" => 39,
                "desconto_comissao" => 0,
            ]);
        }
    }
}
