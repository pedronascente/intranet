<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TecnicaAlarmesCercaEletricaCFTVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 200; $i++) {
            DB::table('tecnica_alarmes_cerca_eletrica_cftvs')->insert([
                "planilha_id"        => 9,
                "cliente"            => Str::random(10),
                "data"               => "2023-11-12",
                "conta_pedido"       => "1212" . $i,
                "numero_os"          => "213" . $i,
                "servico_id"         => 8,
                "comissao"           => $i,
                "desconto_comissao"  => 0,
            ]);
        }
    }
}
