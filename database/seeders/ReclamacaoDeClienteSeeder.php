<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReclamacaoDeClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for ($i = 1; $i <= 200; $i++) {
            DB::table('reclamacao_de_clientes')->insert([
                "planilha_id"       => 5,
                "cliente"           => Str::random(10),
                "data"              => "2023-11-12",
                "conta_pedido"      => "9999" + $i,
                "comissao"          => 22 + $i,
                "desconto_comissao" => 0,
            ]);
        }
    }
}
