<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ModuloSeeder::class,
            PermissaoSeeder::class,
            PerfilSeeder::class,
            UserSeeder::class,
            BaseSeeder::class,
            EmpresaSeeder::class,
            CargoSeeder::class,
            ColaboradorSeeder::class,
            CartaoSeeder::class,
            TokenSeeder::class,
            ModuloPerfilSeeder::class,
            PerfilPermissaoSeeder::class,
            MeioSeeder::class,
            ServicoAlarmeSeeder::class,
            PlanilhaTipoSeeder::class,
            PlanilhaPeriodoSeeder::class,
            PlanilhaStatusSeeder::class,
            PlanilhaSeeder::class,
            ComercialAlarmeCercaEletricaCFTVSeeder::class,
            ComercialRastreamentoVeicularSeeder::class,
            EntregaDeAlarmesSeeder::class,
            PortariaVirtualSeeder::class,
            ReclamacaoDeClienteSeeder::class,
            SupervisaoComercialAlarmesCercaEletricaCFTVSeeder::class,
            SupervisaoComercialRastreamentoSeeder::class,
            SupervisaoTecnicaeSACAlarmesCercaEletricaCFTVSeeder::class,
            TecnicaAlarmesCercaEletricaCFTVSeeder::class,
            TecnicaDeRastreamentoSeeder::class,
        ]);
    }
}
