<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;

Route::prefix('/login')->group(function () {
    Route::get('/', [LoginController::class, 'showForm'])->name('login.form');
    Route::post('/', [LoginController::class, 'login'])->name('login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.sair');
});
Route::prefix('/token')->group(function () {
    Route::get('/', [TokenController::class, 'create'])->name('token.create')->middleware('auth');
    Route::post('/', [TokenController::class, 'store'])->name('token.store')->middleware('auth');
});
Route::middleware(['auth', 'verificarToken'])->group(
    function () {
        Route::redirect('/', '/dashboard', 301);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    }
);

Route::get('/cartao/posicao', [CartaoController::class, 'getPosicaoDoTokenNoCartao'])->middleware('auth');
Route::middleware(['auth', 'verificarToken', 'verificarModulos'])->group(function () {
    Route::prefix('/settings')->group(
        function () {
            Route::resource('/cargo', CargoController::class);
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
            Route::prefix('/associar/usuario')->group(
                function () {
                    Route::get('/{id}', [ColaboradorController::class, 'createAssociar'])->name('create_associar');
                    Route::put('/{id}', [ColaboradorController::class, 'associarUsuario'])->name('update_associar');
                    Route::delete('/{id}', [ColaboradorController::class, 'desassociarUsuario'])->name('destroy.associacao.colaborador');
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
            Route::resource('/colaborador', ColaboradorController::class);
            Route::resource('/empresa', EmpresaController::class);
            Route::resource('/permissao', PermissaoController::class);
            Route::resource('/modulo', ModuloController::class);
            Route::resource('/user', UserController::class);
        }
    );
});

Route::middleware(['auth', 'verificarToken'])->group(
    function () {
        Route::get('/settings', function () {
            return view('settings..index');
        })->name('configuracoes');
    }
);

Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');;
