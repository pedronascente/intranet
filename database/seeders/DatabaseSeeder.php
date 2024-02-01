<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
           
            PermissaoSeeder::class,
            PerfilSeeder::class,
            BaseSeeder::class,
            EmpresaSeeder::class,
            CargoSeeder::class,
            ColaboradorSeeder::class,
            UserSeeder::class,
            TokenSeeder::class,
            ModuloPosicoesSeeder::class,
            ModuloCategoriasSeeder::class,
            ModuloSeeder::class,
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