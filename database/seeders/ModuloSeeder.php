<?php

namespace Database\Seeders;

use \Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run()
    {

        DB::table('modulos')->insert(['nome' => 'Cargo',        'rota' => '/settings/cargo',       'descricao' => "Responsável por Gerenciar Cargo."]);
        DB::table('modulos')->insert(['nome' => 'Colaborador',  'rota' => '/settings/colaborador', 'descricao' => "Responsável por Gerenciar Colaborador."]);
        DB::table('modulos')->insert(['nome' => 'Empresa',      'rota' => '/settings/empresa',     'descricao' => "Responsável por Gerenciar Empresa."]);
        DB::table('modulos')->insert(['nome' => 'Modulos',      'rota' => '/settings/modulo',      'descricao' => "Responsável por Gerenciar Modulo."]);
        DB::table('modulos')->insert(['nome' => 'Permissão',    'rota' => '/settings/permissao',   'descricao' => "Responsável por Gerenciar Permissão."]);
        DB::table('modulos')->insert(['nome' => 'Perfil',       'rota' => '/settings/perfil',      'descricao' => "Responsável por Gerenciar Perfil de usuário."]);
        DB::table('modulos')->insert(['nome' => 'Usuário',      'rota' => '/settings/user',        'descricao' => "Responsável por Gerenciar Usuario."]);
        DB::table('modulos')->insert(['nome' => 'Cartão Token', 'rota' => '/settings/cartao',     'descricao' => "Responsável por ."]);
        DB::table('modulos')->insert(['nome' => 'RH',           'rota' => '/setor01', 'descricao' => Str::random(5)]);
        DB::table('modulos')->insert(['nome' => 'Rastreamento', 'rota' => '/setor02', 'descricao' => Str::random(5)]);
        DB::table('modulos')->insert(['nome' => 'Portaria',     'rota' => '/setor03', 'descricao' => Str::random(5)]);
        DB::table('modulos')->insert(['nome' => 'Alarme',       'rota' => '/setor04', 'descricao' => Str::random(5)]);
    }
}
