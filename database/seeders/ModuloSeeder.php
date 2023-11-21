<?php

namespace Database\Seeders;

use \Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    public function run()
    {
        DB::table('modulos')->insert(['nome' => 'Cargo',        'rota' => '/configuracoes/cargo',         'slug' => 'cargo',        'descricao' => "Responsável por Gerenciar Cargo."]);
        DB::table('modulos')->insert(['nome' => 'Colaborador',  'rota' => '/configuracoes/colaborador',   'slug' => 'colaborador',  'descricao' => "Responsável por Gerenciar Colaborador."]);
        DB::table('modulos')->insert(['nome' => 'Empresa',      'rota' => '/configuracoes/empresa',       'slug' => 'empresa',      'descricao' => "Responsável por Gerenciar Empresa."]);
        DB::table('modulos')->insert(['nome' => 'Modulos',      'rota' => '/configuracoes/modulo',        'slug' => 'modulo',       'descricao' => "Responsável por Gerenciar Modulo."]);
        DB::table('modulos')->insert(['nome' => 'Permissão',    'rota' => '/configuracoes/permissao',     'slug' => 'permissao',    'descricao' => "Responsável por Gerenciar Permissão."]);
        DB::table('modulos')->insert(['nome' => 'Perfil',       'rota' => '/configuracoes/perfil',        'slug' => 'perfil',       'descricao' => "Responsável por Gerenciar Perfil de usuário."]);
        DB::table('modulos')->insert(['nome' => 'Usuário',      'rota' => '/configuracoes/user',          'slug' => 'user',         'descricao' => "Responsável por Gerenciar Usuario."]);
        DB::table('modulos')->insert(['nome' => '2FA',          'rota' => '/configuracoes/cartao',        'slug' => 'cartao',       'descricao' => "Responsável por registar 2FA de acesso."]);
        DB::table('modulos')->insert(['nome' => 'Base',         'rota' => '/configuracoes/base',          'slug' => 'base',         'descricao' => "Responsável por Criar as Bases."]);
    }
}
