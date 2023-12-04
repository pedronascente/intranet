<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanilhaStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planilha_status')->insert(['status' => 'Arquivado']);
        DB::table('planilha_status')->insert(['status' => 'Homologação']);
        DB::table('planilha_status')->insert(['status' => 'Reprovado']);
    }
}
