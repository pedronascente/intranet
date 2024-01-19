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
use App\Http\Controllers\Planilha\AdministrativoController;
use App\Http\Controllers\Planilha\ArquivoController;
use App\Http\Controllers\Planilha\ColaboradorController as PlanilhaColaboradorController;
use App\Http\Controllers\Planilha\RelatorioController as PlanilhaRelatorioController;
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
    Route::get('/', [LoginController::class, 'create'])->name('login.form');
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

Route::middleware(['auth', 'verificarToken'])->group(function () {
    Route::prefix('/configuracoes')->group(function () {
        Route::middleware(['verificarModulos:Perfil'])->group(function () {
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
        });        
        Route::resource('/colaborador', ColaboradorController::class)->middleware(['verificarModulos:Colaborador']);
        Route::resource('/empresa', EmpresaController::class)->middleware(['verificarModulos:Empresa']);
        Route::resource('/permissao', PermissaoController::class)->middleware(['verificarModulos:Permissão']);
        Route::resource('/modulo', ModuloController::class)->middleware(['verificarModulos:Modulo']);
        Route::resource('/user', UserController::class)->middleware(['verificarModulos:Usuário']);
        Route::resource('/base', BaseController::class)->middleware(['verificarModulos:Base']);
        Route::resource('/cargo', CargoController::class)->middleware(['verificarModulos:Cargo']);
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


Route::middleware(['verificarModulos:Lançar Comissão'])->group(function () {
    Route::prefix('/comissao')->group(function () {
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

Route::middleware(['verificarModulos:Administrar Comissão'])->group(function () {
    Route::prefix('/comissao')->group(function () {
        Route::name('comissao.')->group(function () {
            Route::resource('/administrativo', AdministrativoController::class);
            Route::get('/{filtro}', [AdministrativoController::class, 'pesquisarPor'])->name('administrativo.filtro');
        });

        Route::prefix('/administrativo')->group(function () {
            Route::prefix('/reprovar')->group(function () {
                Route::name('comissao.')->group(function () {
                    Route::get('/{id}', [AdministrativoController::class, 'editReprovar'])->name('administrativo.reprovar');
                    Route::put('/{id}', [AdministrativoController::class, 'updateReprovar'])->name('administrativo.reprovarUpdate');
                });
            });
            Route::get('/imprimir-pdf/{id}', [PlanilhaTipoAdministrativoController::class, 'imprimirPDF'])->name('comissao.administrativo.imprimirPDF');
            Route::get('relatorio/buscar', [PlanilhaRelatorioController::class, 'relatorio'])->name('comissao.administrativo.relatorio');
            Route::get('{id}/planilha', [PlanilhaTipoAdministrativoController::class, 'index'])->name('comissao.administrativo-tipo.index');
        });

        Route::prefix('/arquivos')->group(function () {
            Route::get('/', [ArquivoController::class, 'index'])->name('comissao.arquivo.index');
            Route::get('/{filtro}', [ArquivoController::class, 'pesquisarPor'])->name('comissao.arquivo.filtro');
        });

        Route::name('comissao.')->group(function () {
            Route::get('/{id}/recuperar', [ArquivoController::class, 'recuperar'])->name('administrativo.recuperar');
            Route::get('/{id}/arquivar', [ArquivoController::class, 'arquivar'])->name('administrativo.arquivar');
        });
    });
});




