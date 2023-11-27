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


use App\Http\Controllers\Comissao\PlanilhaController;
use App\Http\Controllers\Comissao\ComissaoController;
use App\Http\Controllers\Comissao\ComercialAlarmeCercaEletricaCFTVController;
use App\Http\Controllers\Comissao\ComercialRastreamentoVeicularController;
use App\Http\Controllers\Comissao\EntregaDeAlarmeController;
use App\Http\Controllers\Comissao\PortariaVirtualController;
use App\Http\Controllers\Comissao\ReclamacaoDeClienteController;
use App\Http\Controllers\Comissao\SupervisaoComercialAlarmesCercaEletricaCFTVController;
use App\Http\Controllers\Comissao\SupervisaoComercialRastreamentoController;
use App\Http\Controllers\Comissao\SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController;
use App\Http\Controllers\Comissao\TecnicaDeRastreamentoController;
use App\Http\Controllers\Comissao\TecnicaAlarmesCercaEletricaCFTVController;

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

Route::prefix('/planilha')->group(function () {
    Route::get('/', [PlanilhaController::class, 'index'])->name('planilha.index');
    Route::get('/create', [PlanilhaController::class, 'create'])->name('planilha.create');
    Route::get('/{id}/homologar', [PlanilhaController::class, 'homologar'])->name('planilha.homologar');
    Route::get('/{id}/edit', [PlanilhaController::class, 'edit'])->name('planilha.edit');
    Route::post('/', [PlanilhaController::class, 'store'])->name('planilha.store');
    Route::put('/{id}', [PlanilhaController::class, 'update'])->name('planilha.update');
    Route::delete('/{id}', [PlanilhaController::class, 'destroy'])->name('planilha.destroy');
});

Route::prefix('/comissao')->group(function () {
    Route::get('/planilha/{id}', [ComissaoController::class, 'index'])->name('comissao.index');
    Route::get('/{id}/edit', [ComissaoController::class, 'edit'])->name('comissao.edit');
    Route::post('/', [ComissaoController::class, 'store'])->name('comissao.store');
});

Route::prefix('/tecnica-de-rastreamento')->group(function () {
    Route::get('/{id}/edit', [TecnicaDeRastreamentoController::class, 'edit'])->name('tecnica.de.rastreamento.edit');
    Route::post('/', [TecnicaDeRastreamentoController::class, 'store'])->name('tecnica.de.rastreamento.store');
    Route::put('/{id}', [TecnicaDeRastreamentoController::class, 'update'])->name('tecnica.de.rastreamento.update');
    Route::delete('/{id}', [TecnicaDeRastreamentoController::class, 'destroy'])->name('tecnica.de.rastreamento.destroy');
});

Route::prefix('/comercial-alarme-cerca-eletrica-cftv')->group(function () {
    Route::get('/{id}/edit', [ComercialAlarmeCercaEletricaCFTVController::class, 'edit'])->name('comercial.alarme.cerca.eletrica.cftv.edit');
    Route::post('/', [ComercialAlarmeCercaEletricaCFTVController::class, 'store'])->name('comercial.alarme.cerca.eletrica.cftv.store');
    Route::put('/{id}', [ComercialAlarmeCercaEletricaCFTVController::class, 'update'])->name('comercial.alarme.cerca.eletrica.cftv.update');
    Route::delete('/{id}', [ComercialAlarmeCercaEletricaCFTVController::class, 'destroy'])->name('comercial.alarme.cerca.eletrica.cftv.destroy');
});

Route::prefix('/comercial-rastreamento-veicular')->group(function () {
    Route::get('/{id}/edit', [ComercialRastreamentoVeicularController::class, 'edit'])->name('comercial.rastreamento.veicular.edit');
    Route::post('/', [ComercialRastreamentoVeicularController::class, 'store'])->name('comercial.rastreamento.veicular.store');
    Route::put('/{id}', [ComercialRastreamentoVeicularController::class, 'update'])->name('comercial.rastreamento.veicular.update');
    Route::delete('/{id}', [ComercialRastreamentoVeicularController::class, 'destroy'])->name('comercial.rastreamento.veicular.destroy');
});

Route::prefix('/entrega-de-alarme')->group(function () {
    Route::get('/{id}/edit', [EntregaDeAlarmeController::class, 'edit'])->name('entrega.alarme.edit');
    Route::post('/', [EntregaDeAlarmeController::class, 'store'])->name('entrega.alarme.store');
    Route::put('/{id}', [EntregaDeAlarmeController::class, 'update'])->name('entrega.alarme.update');
    Route::delete('/{id}', [EntregaDeAlarmeController::class, 'destroy'])->name('entrega.alarme.destroy');
});

Route::prefix('/portaria-virtual')->group(function () {
    Route::get('/{id}/edit', [PortariaVirtualController::class, 'edit'])->name('portaria.virtual.edit');
    Route::post('/', [PortariaVirtualController::class, 'store'])->name('portaria.virtual.store');
    Route::put('/{id}', [PortariaVirtualController::class, 'update'])->name('portaria.virtual.update');
    Route::delete('/{id}', [PortariaVirtualController::class, 'destroy'])->name('portaria.virtual.destroy');
});


Route::prefix('/reclamacao-de-cliente')->group(function () {
    Route::get('/{id}/edit', [ReclamacaoDeClienteController::class, 'edit'])->name('reclamacao.de.cliente.edit');
    Route::post('/', [ReclamacaoDeClienteController::class, 'store'])->name('reclamacao.de.cliente.store');
    Route::put('/{id}', [ReclamacaoDeClienteController::class, 'update'])->name('reclamacao.de.cliente.update');
    Route::delete('/{id}', [ReclamacaoDeClienteController::class, 'destroy'])->name('reclamacao.de.cliente.destroy');
});

Route::prefix('/supervisao-comercial-alarmes-cerca-eletrica-cftv')->group(function () {
    Route::get('/{id}/edit', [SupervisaoComercialAlarmesCercaEletricaCFTVController::class, 'edit'])->name('supervisao.comercial.alarmes.cerca.eletrica.cftv.edit');
    Route::post('/', [SupervisaoComercialAlarmesCercaEletricaCFTVController::class, 'store'])->name('supervisao.comercial.alarmes.cerca.eletrica.cftv.store');
    Route::put('/{id}', [SupervisaoComercialAlarmesCercaEletricaCFTVController::class, 'update'])->name('supervisao.comercial.alarmes.cerca.eletrica.cftv.update');
    Route::delete('/{id}', [SupervisaoComercialAlarmesCercaEletricaCFTVController::class, 'destroy'])->name('supervisao.comercial.alarmes.cerca.eletrica.cftv.destroy');
});

Route::prefix('/supervisao-comercial-rastreamento')->group(function () {
    Route::get('/{id}/edit', [SupervisaoComercialRastreamentoController::class, 'edit'])->name('supervisao.comercial.rastreamento.edit');
    Route::post('/', [SupervisaoComercialRastreamentoController::class, 'store'])->name('supervisao.comercial.rastreamento.store');
    Route::put('/{id}', [SupervisaoComercialRastreamentoController::class, 'update'])->name('supervisao.comercial.rastreamento.update');
    Route::delete('/{id}', [SupervisaoComercialRastreamentoController::class, 'destroy'])->name('supervisao.comercial.rastreamento.destroy');
});

Route::prefix('/supervisao-tecnica-sac-alarmes-cerca-eletrica.cftv')->group(function () {
    Route::get('/{id}/edit', [SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController::class, 'edit'])->name('supervisao.tecnica.sac.alarmes.cerca.eletrica.cftv.edit');
    Route::post('/', [SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController::class, 'store'])->name('supervisao.tecnica.sac.alarmes.cerca.eletrica.cftv.store');
    Route::put('/{id}', [SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController::class, 'update'])->name('supervisao.tecnica.sac.alarmes.cerca.eletrica.cftv.update');
    Route::delete('/{id}', [SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController::class, 'destroy'])->name('supervisao.tecnica.sac.alarmes.cerca.eletrica.cftv.destroy');
});


Route::prefix('/tecnica-alarmes-cerca-eletrica-cftv')->group(function () {
    Route::get('/{id}/edit', [TecnicaAlarmesCercaEletricaCFTVController::class, 'edit'])->name('tecnica.alarmes.cerca.eletrica.cftv.edit');
    Route::post('/', [TecnicaAlarmesCercaEletricaCFTVController::class, 'store'])->name('tecnica.alarmes.cerca.eletrica.cftv.store');
    Route::put('/{id}', [TecnicaAlarmesCercaEletricaCFTVController::class, 'update'])->name('tecnica.alarmes.cerca.eletrica.cftv.update');
    Route::delete('/{id}', [TecnicaAlarmesCercaEletricaCFTVController::class, 'destroy'])->name('tecnica.alarmes.cerca.eletrica.cftv.destroy');
});

