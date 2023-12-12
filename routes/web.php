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
use App\Http\Controllers\Configuracoes\CartaoController;
use App\Http\Controllers\Configuracoes\ModuloController;
use App\Http\Controllers\Configuracoes\PerfilController;
use App\Http\Controllers\Configuracoes\EmpresaController;
use App\Http\Controllers\Configuracoes\PermissaoController;
use App\Http\Controllers\Configuracoes\ColaboradorController;
use App\Http\Controllers\Planilha\PlanlhaAdministrativoController;
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

Route::middleware('auth')->get('/cartao/posicao', [CartaoController::class, 'getPosicaoDoTokenNoCartao']);
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
            Route::prefix('/cartao')->group(
                function () {
                    Route::get('/', [CartaoController::class, 'index'])->name('cartao.index');
                    Route::get('/create', [CartaoController::class, 'create'])->name('cartao.create');
                    Route::get('/{id}', [CartaoController::class, 'show'])->name('cartao.show');
                    Route::get('/{id}/edit', [CartaoController::class, 'edit'])->name('cartao.edit');
                    Route::put('/{id}', [CartaoController::class, 'update'])->name('cartao.update');
                    Route::post('/', [CartaoController::class, 'store'])->name('cartao.store');
                    Route::delete('/{id}', [CartaoController::class, 'destroy'])->name('cartao.destroy');
                    Route::get('/registrar/user/{id}', [CartaoController::class, 'registrarCartaoUsuario'])->name('cartao.registar');
                }
            );
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

Route::get('profile', [UserController::class, 'profile'])->name('profile');
Route::put('profile/security/{id}', [UserController::class, 'resetPassword'])->name('user.security');
Route::get('profile/{id}/edit', [ColaboradorController::class, 'editProfile'])->name('user.edit.profile');
Route::get('/senha/{email}/{token}', [UserController::class, 'senhaCreate'])->name('senha');
Route::get('/senha', [UserController::class, 'senhaSucesso']);
Route::prefix('/recuperar')->group(function () {
    Route::get('/', [UserController::class, 'recuperarSenhaCreate'])->name('user.recuperar');
    Route::post('/', [UserController::class, 'recuperarSenhaStore']);
    Route::get('/sucesso', [UserController::class, 'recuperarSenhaSucesso']);
});

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

Route::resource('/planilha-administrativo', PlanlhaAdministrativoController::class);
Route::resource('/planilha-colaborador', PlanilhaColaboradorController::class);
Route::prefix('/planilha-colaborador')->group(function () {
    Route::get('/{id}/homologar', [PlanilhaColaboradorController::class, 'homologar'])->name('planilha-colaborador.homologar');
    Route::get('/filtro', [PlanilhaColaboradorController::class, 'filtro'])->name('planilha-colaborador.filtro');
});

Route::get('planilha-colaborador/{id}/comissao', [PlanilhaTipoColaboradorController::class, 'index'])->name('planilha-colaborador-tipo.index');
Route::get('planilha-administrativo/{id}/comissao', [PlanilhaTipoAdministrativoController::class, 'index'])->name('planilha-administrativo-tipo.index');
