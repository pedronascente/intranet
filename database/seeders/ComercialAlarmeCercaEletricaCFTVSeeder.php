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
        for ($i = 1; $i <= 200; $i++) {
            DB::table('comercial_alarme_cerca_eletrica_cftvs')->insert([
                "planilha_id"       => 1,
                "cliente"           => Str::random(10),
                "data"              => "2023-12-12",
                "servico_id"        => 5,
                "conta_pedido"      => "999899" . $i,
                "meio_id"           => 2,
                "ins_vendas"        => 56,
                "mensal"            => $i,
                "comissao"          => 39,
                "desconto_comissao" => 0,
            ]);
        }
    }
}
