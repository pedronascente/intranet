<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColaboradorSeeder extends Seeder
{
    public function run()
    {
        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 5,
            'cargo_id'         => 49,
            'nome'             => 'Pedro Nascente',
            'email'            => 'desenvolvimento@grupovolpato.com',
            'rg'               => '99999999999999',
            'cpf'              => '99999999991',
            'foto'             => 'dummy-round.png',
            'ramal'            => '999',
            'numero_matricula' => '9999999',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Deise Lilian dos Santos Pereira',
            'email'            => 'vendas03@grupovolpato.com',
            'rg'               => '1077262135',
            'cpf'              => '89473159072',
            'foto'             => 'dummy-round.png',
            'ramal'            => '509',
            'numero_matricula' => '1000000000',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Tiago Freitas Rodrigues',
            'email'            => 'tiago.rodrigues@grupovolpato.com',
            'rg'               => '99999999992',
            'cpf'              => '81032412020',
            'foto'             => 'dummy-round.png',
            'ramal'            => '508',
            'numero_matricula' => '1000000001',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Grazielle Silveira',
            'email'            => 'grazielle.silveira@grupovolpato.com',
            'rg'               => '6065195205',
            'cpf'              => '965.139.930-91',
            'foto'             => 'dummy-round.png',
            'ramal'            => '529',
            'numero_matricula' => '1000000002',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Deise Nunes',
            'email'            => 'deise.nunes@grupovolpato.com',
            'rg'               => '99999999993',
            'cpf'              => '83939792004',
            'foto'             => 'dummy-round.png',
            'ramal'            => '506',
            'numero_matricula' => '1000000003',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 57,
            'nome'             => 'Anamara Hoppe',
            'email'            => 'anamara.hoppe@grupovolpato.com',
            'rg'               => '99999999994',
            'cpf'              => '99999999995',
            'foto'             => 'dummy-round.png',
            'ramal'            => '514',
            'numero_matricula' => '1000000004',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Taís Corrêa',
            'email'            => 'tais.correa@grupovolpato.com',
            'rg'               => '6085845516',
            'cpf'              => '985.552.510-87',
            'foto'             => 'dummy-round.png',
            'ramal'            => '512',
            'numero_matricula' => '1000000005',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Maria Eduarda Dutra',
            'email'            => 'maria.dutra@grupovolpato.com',
            'rg'               => '3125631584',
            'cpf'              => '87155460044',
            'foto'             => 'dummy-round.png',
            'ramal'            => '505',
            'numero_matricula' => '1000000006',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Helenir Souza',
            'email'            => 'helenir.souza@grupovolpato.com',
            'rg'               => '1089285751',
            'cpf'              => '01092653007',
            'foto'             => 'dummy-round.png',
            'ramal'            => '513',
            'numero_matricula' => '1000000007',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Katia Beatriz',
            'email'            => 'katia.beatriz@grupovolpato.com',
            'rg'               => '99999999934',
            'cpf'              => '00009370021',
            'foto'             => 'dummy-round.png',
            'ramal'            => '515',
            'numero_matricula' => '1000000008',
        ]);

        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Pedro Henrique',
            'email'            => 'pedro.henrique@grupovolpato.com',
            'rg'               => '99999999955',
            'cpf'              => '99999999944',
            'foto'             => 'dummy-round.png',
            'ramal'            => '528',
            'numero_matricula' => '1000000009',
        ]);
        DB::table('colaboradores')->insert([
            'base_id'          => 1,
            'empresa_id'       => 2,
            'cargo_id'         => 71,
            'nome'             => 'Francisco Maia',
            'email'            => 'francisco.maia@grupovolpato.com',
            'rg'               => '1100199502',
            'cpf'              => '02363703081',
            'foto'             => 'dummy-round.png',
            'ramal'            => '529',
            'numero_matricula' => '1000000010',
        ]);
    }
}