<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
#Login
use App\Http\Controllers\Login\UserController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\TokenController;
#Settings
use App\Http\Controllers\Settings\BaseController;
use App\Http\Controllers\Settings\CargoController;
use App\Http\Controllers\Settings\CartaoController;
use App\Http\Controllers\Settings\ModuloController;
use App\Http\Controllers\Settings\PerfilController;
use App\Http\Controllers\Settings\EmpresaController;
use App\Http\Controllers\Settings\PermissaoController;
use App\Http\Controllers\Settings\ColaboradorController;
#Comissao
use App\Http\Controllers\Comissao\ComissaoController;
use App\Http\Controllers\Comissao\PlanilhaController;
use App\Http\Controllers\comissao\TecnicaDeRastreamentoController;
use App\Http\Controllers\comissao\ComercialAlarmeCercaEletricaCFTV;
use App\Http\Controllers\comissao\ComercialRastreamentoVeicular;

Route::prefix('/login')
    ->group(function () {
        Route::get('/', [LoginController::class, 'showForm'])->name('login.form');
        Route::get('/logout', [LoginController::class, 'logout'])->name('login.sair');
        Route::post('/', [LoginController::class, 'login'])->name('login');
    });

Route::middleware('auth')
    ->prefix('/token')
    ->group(function () {
        Route::get('/', [TokenController::class, 'create'])->name('token.create');
        Route::post('/', [TokenController::class, 'store'])->name('token.store');
    });

Route::middleware('auth')
    ->get('/cartao/posicao', [CartaoController::class, 'getPosicaoDoTokenNoCartao']);

Route::middleware(['auth', 'verificarToken'])
    ->group(
        function () {
            Route::redirect('/', '/dashboard', 301);
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
            Route::get('/settings', function () {
                return view('settings.index');
            })->name('configuracoes');
        }
    );

Route::middleware(['auth', 'verificarToken', 'verificarModulos'])
    ->group(function () {
        Route::prefix('/settings')
            ->group(
                function () {
                    Route::prefix('/cartao')
                        ->group(
                            function () {
                                Route::get('/', [CartaoController::class, 'index'])->name('cartao.index');
                                Route::get('/create', [CartaoController::class, 'create'])->name('cartao.create');
                                Route::get('/{id}', [CartaoController::class, 'show'])->name('cartao.show');
                                Route::get('/{id}/edit', [CartaoController::class, 'edit'])->name('cartao.edit');
                                Route::put('/{id}', [CartaoController::class, 'update'])->name('cartao.update');
                                Route::post('/', [CartaoController::class, 'store'])->name('cartao.store');
                                Route::delete('/{id}', [CartaoController::class, 'destroy'])->name('cartao.destroy');
                                Route::get('/registrar/user/{id}', [CartaoController::class, 'registrarCartaoUsuario'])
                                    ->name('cartao.registar');
                            }
                        );
                    Route::prefix('/perfil')
                        ->group(function () {
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

Route::get('profile', [UserController::class, 'profile'])
    ->name('profile');
Route::put('profile/security/{id}', [UserController::class, 'resetPassword'])
    ->name('user.security');
Route::get('profile/{id}/edit', [ColaboradorController::class, 'editProfile'])
    ->name('user.edit.profile');

//tens qque fazer uma api:

Route::prefix('/recuperar')
    ->group(function () {
        Route::get('/', [UserController::class, 'recuperarSenhaCreate'])
            ->name('user.recuperar');
        Route::post('/', [UserController::class, 'recuperarSenhaStore']);
        Route::get('/sucesso', [UserController::class, 'recuperarSenhaSucesso']);
    });

Route::get('/senha/{email}/{token}', [UserController::class, 'senhaCreate'])
    ->name('senha');
Route::get('/senha', [UserController::class, 'senhaSucesso']);

Route::prefix('/planilha')
    ->group(function () {
        Route::get('/', [PlanilhaController::class, 'index'])
            ->name('planilha.index');
        Route::get('/create', [PlanilhaController::class, 'create'])
            ->name('planilha.create');
        Route::get('/{id}/homologar', [PlanilhaController::class, 'homologar'])
            ->name('planilha.homologar');
        Route::get('/{id}/edit', [PlanilhaController::class, 'edit'])
            ->name('planilha.edit');
        Route::post('/', [PlanilhaController::class, 'store'])
            ->name('planilha.store');
        Route::put('/{id}', [PlanilhaController::class, 'update'])
            ->name('planilha.update');
        Route::delete('/{id}', [PlanilhaController::class, 'destroy'])
            ->name('planilha.destroy');
    });

Route::prefix('/comissao')->group(function () {
    Route::get('/planilha/{id}', [ComissaoController::class, 'index'])
        ->name('comissao.index');
    Route::get('/{id}/edit', [ComissaoController::class, 'edit'])
        ->name('comissao.edit');
    Route::post('/', [ComissaoController::class, 'store'])
        ->name('comissao.store');
});

Route::prefix('/tecnicaDeRastreamento')
    ->group(function () {
        Route::get('/{id}/edit', [TecnicaDeRastreamentoController::class, 'edit'])
            ->name('tecnicaDeRastreamento.edit');
        Route::post('/', [TecnicaDeRastreamentoController::class, 'store'])
            ->name('tecnicaDeRastreamento.store');
        Route::put('/{id}', [TecnicaDeRastreamentoController::class, 'update'])
            ->name('tecnicaDeRastreamento.update');
        Route::delete('/{id}', [TecnicaDeRastreamentoController::class, 'destroy'])
            ->name('tecnicaDeRastreamento.destroy');
    });

Route::prefix('/comercialAlarmeCercaEletricaCFTV')
    ->group(function () {
        Route::get('/{id}/edit', [ComercialAlarmeCercaEletricaCFTV::class, 'edit'])
            ->name('comercialAlarmeCercaEletricaCFTV.edit');
        Route::post('/', [ComercialAlarmeCercaEletricaCFTV::class, 'store'])
            ->name('comercialAlarmeCercaEletricaCFTV.store');
        Route::put('/{id}', [ComercialAlarmeCercaEletricaCFTV::class, 'update'])
            ->name('comercialAlarmeCercaEletricaCFTV.update');
        Route::delete('/{id}', [ComercialAlarmeCercaEletricaCFTV::class, 'destroy'])
            ->name('comercialAlarmeCercaEletricaCFTV.destroy');
    });

Route::prefix('/comercialRastreamentoVeicular')
    ->group(function () {
        Route::get('/{id}/edit', [ComercialRastreamentoVeicular::class, 'edit'])
            ->name('comercialRastreamentoVeicular.edit');
        Route::post('/', [ComercialRastreamentoVeicular::class, 'store'])
            ->name('comercialRastreamentoVeicular.store');
        Route::put('/{id}', [ComercialRastreamentoVeicular::class, 'update'])
            ->name('comercialRastreamentoVeicular.update');
        Route::delete('/{id}', [ComercialRastreamentoVeicular::class, 'destroy'])
            ->name('comercialRastreamentoVeicular.destroy');
    });
