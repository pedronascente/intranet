<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanilhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('planilhas')->insert([
                "colaborador_id"      => 1,
                "ctps"                => "0000" . $i,
                "matricula"           => "9999" . $i,
                "planilha_tipo_id"    => $i,
                "ano"                 => "2023",
                "planilha_periodo_id" => 1,
                "planilha_status_id"  => 1,
            ]);
        }
    }
}
