<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    public function run()
    {
        DB::table('empresas')->insert(['nome' => 'VOLPATO', 'cnpj' => '83376348000105']);
        DB::table('empresas')->insert(['nome' => 'EASYSE', 'cnpj' => '12212759000117']);
        DB::table('empresas')->insert(['nome' => 'VOLPMANN', 'cnpj' => '63893701000117']);
        DB::table('empresas')->insert(['nome' => 'GRUPO VOLPATO', 'cnpj' => '90275275000120']);
    }
}
