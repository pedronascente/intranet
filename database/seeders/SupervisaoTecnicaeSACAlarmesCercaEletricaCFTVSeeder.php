<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupervisaoTecnicaeSACAlarmesCercaEletricaCFTVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 200; $i++) {
            DB::table('supervisao_tecnica_e_sac_alarmes_cerca_eletrica_cftvs')->insert([
                "planilha_id"       => 8,
                "cliente"           => Str::random(10),
                "data"              => "2023-11-12",
                "conta_pedido"      => "23434",
                "equipe_servico"    => Str::random(10),
                "ins_vendas"        => $i,
                "mensal"            => $i,
                "comissao"          => $i,
                "desconto_comissao" => 0,
            ]);
        }
    }
}
