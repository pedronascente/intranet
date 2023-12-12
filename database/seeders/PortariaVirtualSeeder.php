<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PortariaVirtualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for ($i = 1; $i <= 200; $i++) {
            DB::table('portaria_virtuais')->insert([
                "planilha_id"       => 4,
                "cliente"           => Str::random(10),
                "data"              => "2023-12-12",
                "meio_id"           => 1,
                "ins_vendas"        => $i + 3,
                "mensal"            => $i + 5,
                "conta_pedido"      => $i + 3,
                "comissao"          => $i + 2,
                "desconto_comissao" => 0,
            ]);
        }
    }
}
