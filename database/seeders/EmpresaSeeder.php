<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    public function run()
    {
        DB::table('empresas')->insert(['nome' => 'VPSP',                'cnpj' => '11000000000001']);
        DB::table('empresas')->insert(['nome' => 'VH',                  'cnpj' => '22000000000002']);
        DB::table('empresas')->insert(['nome' => 'VP - Alarmes',        'cnpj' => '33000000000003']);
        DB::table('empresas')->insert(['nome' => 'VP - Guaíba',         'cnpj' => '44000000000004']);
        DB::table('empresas')->insert(['nome' => 'Volpmann Matriz',     'cnpj' => '55000000000005']);
        DB::table('empresas')->insert(['nome' => 'Volpmann - Filial',   'cnpj' => '66000000000006']);
        DB::table('empresas')->insert(['nome' => 'Volpato - Matriz',    'cnpj' => '77000000000007']);
        DB::table('empresas')->insert(['nome' => 'Volpato - Tramandaí', 'cnpj' => '88000000000008']);
        DB::table('empresas')->insert(['nome' => 'Volpato - Filial',    'cnpj' => '99000000000009']);
        DB::table('empresas')->insert(['nome' => 'Easyseg',             'cnpj' => '101000000000010']);
    }
}