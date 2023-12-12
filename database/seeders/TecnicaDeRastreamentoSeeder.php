<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TecnicaDeRastreamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 200; $i++) {
            DB::table('tecnica_de_rastreamentos')->insert([
                "planilha_id"       => 10,
                "cliente"           => Str::random(10),
                "data"              => "2023-11-12",
                "conta_pedido"      => "234234",
                "placa"             => Str::random(3) . "-" . $i,
                "comissao"          => $i,
                "desconto_comissao" => 0,
                "observacao"        => Str::random(50)
            ]);
        }
    }
}
