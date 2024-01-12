<?php

use Illuminate\Support\Facades\Route;

#Login
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login\UserController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\TokenController;

#Configuracoes
use App\Http\Controllers\Configuracoes\BaseController;
use App\Http\Controllers\Configuracoes\CargoController;
use App\Http\Controllers\Configuracoes\ModuloController;
use App\Http\Controllers\Configuracoes\PerfilController;
use App\Http\Controllers\Configuracoes\EmpresaController;
use App\Http\Controllers\Configuracoes\PermissaoController;
use App\Http\Controllers\Configuracoes\ColaboradorController;
use App\Http\Controllers\Planilha\PlanilhaAdministrativoController;
use App\Http\Controllers\Planilha\PlanilhaColaboradorController;
use App\Http\Controllers\Planilha\Tipo\EntregaDeAlarmeController;
use App\Http\Controllers\Planilha\Tipo\PortariaVirtualController;
use App\Http\Controllers\Planilha\Tipo\ReclamacaoDeClienteController;
use App\Http\Controllers\Planilha\Tipo\TecnicaDeRastreamentoController;
use App\Http\Controllers\Planilha\Tipo\PlanilhaTipoColaboradorController;
use App\Http\Controllers\Planilha\Tipo\PlanilhaTipoAdministrativoController;
use App\Http\Controllers\Planilha\Tipo\ComercialRastreamentoVeicularController;
use App\Http\Controllers\Planilha\Tipo\SupervisaoComercialRastreamentoController;
use App\Http\Controllers\Planilha\Tipo\TecnicaAlarmesCercaEletricaCFTVController;
use App\Http\Controllers\Planilha\Tipo\ComercialAlarmeCercaEletricaCFTVController;
use App\Http\Controllers\Planilha\Tipo\SupervisaoComercialAlarmesCercaEletricaCFTVController;
use App\Http\Controllers\Planilha\Tipo\SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController;

Route::prefix('/login')->group(function () {
    Route::get('/', [LoginController::class, 'showForm'])->name('login.form');
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.sair');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->prefix('/token')->group(function () {
    Route::get('/', [TokenController::class, 'create'])->name('token.create');
    Route::post('/', [TokenController::class, 'store'])->name('token.store');
});

Route::middleware(['auth', 'verificarToken'])->group(
    function () {
        Route::redirect('/', '/dashboard', 301);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/configuracoes', function () {
            return view('configuracoes.index');
        })->name('configuracoes');
    }
);

Route::middleware(['auth', 'verificarToken', 'verificarModulos'])->group(function () {
    Route::prefix('/configuracoes')->group(
        function () {
            Route::prefix('/perfil')->group(function () {
                Route::get('/desativar/{id}', [PerfilController::class, 'desativar']);
                Route::get('/', [PerfilController::class, 'index'])->name('perfil.index');
                Route::get('/create', [PerfilController::class, 'create'])->name('perfil.create');
                Route::get('/{id}', [PerfilController::class, 'show'])->name('perfil.show');
                Route::get('/{id}/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
                Route::put('/{id}', [PerfilController::class, 'update'])->name('perfil.update');
                Route::post('/', [PerfilController::class, 'store'])->name('perfil.store');
                Route::delete('/{id}', [PerfilController::class, 'destroy'])->name('perfil.destroy');
            });
            Route::resource('/cargo', CargoController::class);
            Route::resource('/colaborador', ColaboradorController::class);
            Route::resource('/empresa', EmpresaController::class);
            Route::resource('/permissao', PermissaoController::class);
            Route::resource('/modulo', ModuloController::class);
            Route::resource('/user', UserController::class);
            Route::resource('/base', BaseController::class);
        }
    );
});

Route::prefix('/meu-perfil')->group(function () {
    Route::get('/', [UserController::class, 'meuPerfil'])->name('user.meuPerfil');
    Route::put('/resetar-senha/{id}', [UserController::class, 'resetarSenha'])->name('user.resetarSenha');
    Route::get('/{id}/edit', [ColaboradorController::class, 'editarMeuPerfil'])->name('user.editarMeuPerfil');  
});

Route::get('/senha/{email}/{token}', [UserController::class, 'senhaCreate'])->name('senha');
Route::get('/senha', [UserController::class, 'senhaSucesso']);
Route::prefix('/recuperar')->group(function () {
    Route::get('/', [UserController::class, 'recuperarSenhaCreate'])->name('user.recuperar');
    Route::post('/', [UserController::class, 'recuperarSenhaStore']);
    Route::get('/sucesso', [UserController::class, 'recuperarSenhaSucesso']);
});



// Rotas para Planilha Colaborador
/*
Route::prefix('/planilha/colaborador')->group(function () {
    Route::get('/', [PlanilhaColaboradorController::class, 'index'])->name('planilha-colaborador.index');
    Route::get('/create', [PlanilhaColaboradorController::class, 'create'])->name('planilha-colaborador.create');
    Route::get('/{id}/edit', [PlanilhaColaboradorController::class, 'edit'])->name('planilha-colaborador.edit');
    Route::delete('/{id}', [PlanilhaColaboradorController::class, 'destroy'])->name('planilha-colaborador.destroy');
    Route::put('/{id}', [PlanilhaColaboradorController::class, 'update'])->name('planilha-colaborador.update');
    Route::post('/', [PlanilhaColaboradorController::class, 'store'])->name('planilha-colaborador.store');
    Route::get('/{id}/homologar', [PlanilhaColaboradorController::class, 'homologar'])->name('planilha-colaborador.homologar');
    Route::get('/{id}/comissao', [PlanilhaTipoColaboradorController::class, 'index'])->name('planilha-colaborador-tipo.index');
});

*/

 
Route::prefix('/comissao')->group(function () {
    Route::get('/', [PlanilhaColaboradorController::class, 'index'])->name('planilha-colaborador.index');
    Route::get('/create', [PlanilhaColaboradorController::class, 'create'])->name('planilha-colaborador.create');
    Route::get('/{id}/edit', [PlanilhaColaboradorController::class, 'edit'])->name('planilha-colaborador.edit');
    Route::delete('/{id}', [PlanilhaColaboradorController::class, 'destroy'])->name('planilha-colaborador.destroy');
    Route::put('/{id}', [PlanilhaColaboradorController::class, 'update'])->name('planilha-colaborador.update');
    Route::post('/', [PlanilhaColaboradorController::class, 'store'])->name('planilha-colaborador.store');
    Route::get('/{id}/homologar', [PlanilhaColaboradorController::class, 'homologar'])->name('planilha-colaborador.homologar');
    Route::get('/{id}/plailha', [PlanilhaTipoColaboradorController::class, 'index'])->name('planilha-colaborador-tipo.index');

    Route::resource('/reclamacao-de-cliente', ReclamacaoDeClienteController::class);
    Route::resource('/entrega-de-alarme', EntregaDeAlarmeController::class);
    Route::resource('/supervisao-cace-cftv', SupervisaoComercialAlarmesCercaEletricaCFTVController::class);
    Route::resource('/supervisao-c-r', SupervisaoComercialRastreamentoController::class);
    Route::resource('/tecnica-de-rastreamento', TecnicaDeRastreamentoController::class);
    Route::resource('/stsace-cftv', SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController::class);
    Route::resource('/portaria-virtual', PortariaVirtualController::class);
    Route::resource('/cace-cftv', ComercialAlarmeCercaEletricaCFTVController::class);
    Route::resource('/comercial-rastreamento-veicular', ComercialRastreamentoVeicularController::class);
    Route::resource('/tecnica-ace-cftv', TecnicaAlarmesCercaEletricaCFTVController::class);

    Route::prefix('/pesquisar-colaborador')->group(function () {
        Route::get('/',          [ColaboradorController::class, 'createPesquisar'])->name('colaborador.pesquisar');
        Route::get('/resultado', [ColaboradorController::class, 'showPesquisar'])->name('colaborador.showPesquisar');
    });
});




Route::prefix('/comissao/administrar')->group(function () {

    Route::get('/',          [PlanilhaAdministrativoController::class, 'index'])->name('planilha-administrativo.index');
    Route::get('/create',    [PlanilhaAdministrativoController::class, 'create'])->name('planilha-administrativo.create');
    Route::post('/',         [PlanilhaAdministrativoController::class, 'store'])->name('planilha-administrativo.store');
    Route::get('/{id}/edit', [PlanilhaAdministrativoController::class, 'edit'])->name('planilha-administrativo.edit');
    Route::put('/{id}',      [PlanilhaAdministrativoController::class, 'update'])->name('planilha-administrativo.update');
    //Route::get('/{id}',      [PlanilhaAdministrativoController::class, 'show'])->name('planilha-administrativo.index');
    
    Route::get('/{filtro}',      [PlanilhaAdministrativoController::class, 'show'])->name('planilha-administrativo.filtro');
    Route::get('/{id}/reprovar', [PlanilhaAdministrativoController::class, 'editReprovar'])->name('planilha-administrativo.reprovar');
    Route::get('/{id}/arquivar', [PlanilhaAdministrativoController::class, 'arquivar'])->name('planilha-administrativo.arquivar');
    
    Route::get('{id}/planilha',      [PlanilhaTipoAdministrativoController::class, 'index'])->name('planilha-administrativo-tipo.index');
    Route::get('/imprimir-pdf/{id}', [PlanilhaTipoAdministrativoController::class, 'imprimirPDF'])->name('planilha-administrativo.imprimirPDF');
    
    Route::prefix('/arquivado')->group(function () {
        Route::get('/', [PlanilhaAdministrativoController::class, 'arquivado'])->name('planilha-administrativo.arquivado');
        Route::put('/{id}', [PlanilhaAdministrativoController::class, 'updateReprovar'])->name('planilha-administrativo.reprovarUpdate');
        Route::get('/{id}/recuperar', [PlanilhaAdministrativoController::class, 'recuperar'])->name('planilha-administrativo.recuperar');
    });

});

// Rotas para Planilha Administrativo Arquivo


