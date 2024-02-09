<?php

use Illuminate\Support\Facades\Route;
 
#Login
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login\UserController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\TokenController;

#Configuracoes
use App\Http\Controllers\Planilha\ArquivoController;
use App\Http\Controllers\Configuracoes\BaseController;
use App\Http\Controllers\Configuracoes\CargoController;
use App\Http\Controllers\Configuracoes\ModuloController;
use App\Http\Controllers\Configuracoes\PerfilController;
use App\Http\Controllers\Configuracoes\EmpresaController;
use App\Http\Controllers\Configuracoes\PermissaoController;
use App\Http\Controllers\Planilha\AdministrativoController;
use App\Http\Controllers\Configuracoes\ColaboradorController;
use App\Http\Controllers\Configuracoes\ConfiguracaoController;
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
use App\Http\Controllers\Planilha\RelatorioController as PlanilhaRelatorioController;
use App\Http\Controllers\Planilha\ColaboradorController as PlanilhaColaboradorController;
use App\Http\Controllers\Planilha\Tipo\SupervisaoComercialAlarmesCercaEletricaCFTVController;
use App\Http\Controllers\Planilha\Tipo\SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController;

Route::prefix('/login')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login.form');
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.sair');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->prefix('/token')->group(function () {
    Route::get('/', [TokenController::class, 'create'])->name('token.create');
    Route::post('/', [TokenController::class, 'store'])->name('token.store');
    Route::get('/get-posicao-token', [TokenController::class, 'getPosicaoToken']);
});

Route::middleware(['auth','validarToken', 'gerarMenuDaBarraLateral'])->group(function () {
    Route::redirect('/', '/dashboard', 301);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->middleware(['validarPermissaoDeRota:configuracoes'])->name('configuracoes.index');
});

Route::middleware(['auth', 'validarToken'])->group(function () {
    Route::prefix('/configuracoes')->group(function () {
        Route::middleware(['validarPermissaoDeRota:perfil'])->group(function () {
            Route::resource('/perfil', PerfilController::class);
            Route::get('perfil/desativar/{id}', [PerfilController::class, 'desativar'])->name('perfil.desativar');
        });
        Route::resource('/colaborador', ColaboradorController::class)->middleware(['validarPermissaoDeRota:colaborador']);
        Route::resource('/empresa', EmpresaController::class)->middleware(['validarPermissaoDeRota:empresa']);
        Route::resource('/permissao', PermissaoController::class)->middleware(['validarPermissaoDeRota:permissao']);
        Route::resource('/modulo', ModuloController::class)->middleware(['validarPermissaoDeRota:modulo']);
        Route::resource('/usuario', UserController::class)->middleware(['validarPermissaoDeRota:usuario']);
        Route::resource('/base', BaseController::class)->middleware(['validarPermissaoDeRota:base']);
        Route::resource('/cargo', CargoController::class)->middleware(['validarPermissaoDeRota:cargo']);
    });
});

Route::prefix('/meu-perfil')->group(function () {
    Route::get('/', [UserController::class, 'meuPerfil'])->name('user.meuPerfil');
    Route::put('/resetar-senha/{id}', [UserController::class, 'resetarSenha'])->name('user.resetarSenha');
    Route::get('/{id}/edit', [ColaboradorController::class, 'editarMeuPerfil'])->name('user.editarMeuPerfil');
});

Route::get('/senha/{email}/{token}', [UserController::class, 'senhaCreate'])->name('senha');
Route::get('/senha', [UserController::class, 'senhaSucesso'])->name('user.senhaSucesso');
Route::prefix('/recuperar')->group(function () {
    Route::get('/', [UserController::class, 'recuperarSenhaCreate'])->name('user.recuperarSenhaCreate');
    Route::post('/', [UserController::class, 'recuperarSenhaStore']);
    Route::get('/sucesso', [UserController::class, 'recuperarSenhaSucesso']);
});

Route::middleware(['validarPermissaoDeRota:lancar-comissao'])->group(function () {
    Route::prefix('/comissao')->group(function () {
        Route::get('/', function () {
            return redirect()->route('planilha.index');
        });
        //planililha:
        Route::resource('/planilha', PlanilhaColaboradorController::class);
        Route::get('/planilha{planilha}/homologar', [PlanilhaColaboradorController::class, 'homologar'])->name('planilha.homologar');
        //pesquisar colaborador:   
        Route::prefix('/pesquisar')->group(function () {
            Route::get('/', [ColaboradorController::class, 'createPesquisar'])->name('colaborador.pesquisar');
            Route::get('/resultado', [ColaboradorController::class, 'showPesquisar'])->name('colaborador.showPesquisar');
        });
        //comissoes:
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
    });
});

Route::middleware(['validarPermissaoDeRota:administrar-comissao'])->group(function () {
    Route::prefix('/comissao-administrativo')->group(function () {
        Route::get('/', function () {
            return redirect()->route('comissao.administrativo.index');
        });
        Route::name('comissao.')->group(function () {
            Route::resource('/administrativo', AdministrativoController::class);
            Route::name('administrativo.')->group(function () {
                Route::prefix('/arquivos')->group(function () {
                    Route::get('/', [ArquivoController::class, 'index'])->name('arquivo.index');
                    Route::get('/{id}/recuperar', [ArquivoController::class, 'recuperar'])->name('arquivo.recuperar');
                    Route::get('/{id}/arquivar', [ArquivoController::class, 'arquivar'])->name('arquivo.arquivar');
                });
                Route::prefix('/planilha')->group(function () {
                    Route::get('/{id}/reprovar', [AdministrativoController::class, 'editReprovar'])->name('reprovar');
                    Route::put('/{id}', [AdministrativoController::class, 'updateReprovar'])->name('reprovarUpdate');
                });
                Route::get('/imprimir-pdf/{id}', [PlanilhaTipoAdministrativoController::class, 'imprimirPDF'])->name('imprimirPDF');
                Route::get('{id}/planilha', [PlanilhaTipoAdministrativoController::class, 'index'])->name('tipoAdministrativo.index');
                Route::get('relatorio/buscar', [PlanilhaRelatorioController::class, 'relatorio'])->name('relatorio');
                Route::get('{planilha}/{comissao}/editarComissaoAdministrativo', [AdministrativoController::class, 'editarComissaoAdministrativo'])->name('editarComissaoAdministrativo'); 
            });
        });
    });
});