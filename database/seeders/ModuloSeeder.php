<?php

namespace Database\Seeders;

use \Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulos')->insert(['nome' => 'Cargo',        'rota' => '/settings/cargo',         'slug' => 'cargo',        'descricao' => "Responsável por Gerenciar Cargo."]);
        DB::table('modulos')->insert(['nome' => 'Colaborador',  'rota' => '/settings/colaborador',   'slug' => 'colaborador',  'descricao' => "Responsável por Gerenciar Colaborador."]);
        DB::table('modulos')->insert(['nome' => 'Empresa',      'rota' => '/settings/empresa',       'slug' => 'empresa',      'descricao' => "Responsável por Gerenciar Empresa."]);
        DB::table('modulos')->insert(['nome' => 'Modulos',      'rota' => '/settings/modulo',        'slug' => 'modulo',       'descricao' => "Responsável por Gerenciar Modulo."]);
        DB::table('modulos')->insert(['nome' => 'Permissão',    'rota' => '/settings/permissao',     'slug' => 'permissao',    'descricao' => "Responsável por Gerenciar Permissão."]);
        DB::table('modulos')->insert(['nome' => 'Perfil',       'rota' => '/settings/perfil',        'slug' => 'perfil',       'descricao' => "Responsável por Gerenciar Perfil de usuário."]);
        DB::table('modulos')->insert(['nome' => 'Usuário',      'rota' => '/settings/user',          'slug' => 'user',         'descricao' => "Responsável por Gerenciar Usuario."]);
        DB::table('modulos')->insert(['nome' => '2FA', 'rota' => '/settings/cartao',        'slug' => 'cartao',       'descricao' => "Responsável por registar 2FA de acesso."]);
        DB::table('modulos')->insert(['nome' => 'Base',         'rota' => '/settings/base',          'slug' => 'base',         'descricao' => "Responsável por Criar as Bases."]);
    }
}
