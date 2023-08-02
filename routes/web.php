<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\ColaboradorController;

Route::prefix('/settings')->group(
    function () {
        Route::resource('/empresa', EmpresaController::class);
        Route::resource('/cargo', CargoController::class);
        Route::resource('/permissao', PermissaoController::class);
        Route::resource('/perfil', PerfilController::class);
        Route::resource('/modulo', ModuloController::class);
        Route::resource('/cartao', CartaoController::class);
        Route::get('/cartao/registrar/user/{id}', [CartaoController::class, 'registrarCartaoUsuario'])->name('cartao.registar');
        Route::resource('/colaborador', ColaboradorController::class);
        Route::resource('/user', UserController::class);
        Route::get('/perfil/desativar/{id}', [PerfilController::class, 'desativar']);
        Route::prefix('/associar/colaborador')->group(
            function () {
                Route::get('/{id}', [UserController::class, 'createAssociar'])->name('user.associar');
                Route::put('/{id}', [UserController::class, 'associarColaborador'])->name('user.updateassociar');
                Route::delete('/{id}', [UserController::class, 'desassociarColaborador'])->name('destroy.associacao.user');
            }
        );
        Route::prefix('/associar/usuario')->group(
            function () {
                Route::get('/{id}', [ColaboradorController::class, 'createAssociar'])->name('create_associar');
                Route::put('/{id}', [ColaboradorController::class, 'associarUsuario'])->name('update_associar');
                Route::delete('/{id}', [ColaboradorController::class, 'desassociarUsuario'])->name('destroy.associacao.colaborador');
            }
        );
    }
);

Route::get('/', [LoginController::class, 'showForm'])->name('login.form');
Route::get('/login', [LoginController::class, 'showForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.sair');
Route::get('/token', [TokenController::class, 'create'])->name('token.create')->middleware('auth');
Route::post('/token', [TokenController::class, 'store'])->name('token.store')->middleware('auth');
Route::get('/home', [DashboardController::class, 'index'])->name('home.index')->middleware('auth');



Route::get('/cartao/posicao', [CartaoController::class, 'getPosicaoDoCartaoToken']);







Route::get('/setor01', function () {
    return view('setor_demo');
});

Route::get('/setor02', function () {
    return view('setor_demo');
});

Route::get('/setor03', function () {
    return view('setor_demo');
});

Route::get('/setor04', function () {
    return view('setor_demo');
});

Route::get('/cartao', function () {
    echo 'cartao';
});
