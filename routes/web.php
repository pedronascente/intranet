<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\ColaboradorController;
use \App\Http\Controllers\Auth\RegisteredUserController;

Route::prefix('/settings')->group(
    function () {
        Route::resource('/empresa', EmpresaController::class);
        Route::resource('/cargo', CargoController::class);
        Route::resource('/permissao', PermissaoController::class);
        Route::resource('/perfil', GrupoController::class);
        Route::resource('/modulo', ModuloController::class);
        Route::resource('/cartao', CartaoController::class);
        Route::resource('/colaborador', ColaboradorController::class);
        Route::resource('/user', UserController::class);
        Route::get('/perfil/desativar/{id}', [GrupoController::class, 'desativar']);

        Route::prefix('/associar/user')->group(
            function () {
                Route::get('/{id}', [UserController::class, 'createAssociar'])->name('user.associar');
                Route::put('/{id}', [UserController::class, 'updateAssociar'])->name('user.updateassociar');
                Route::delete('/{id}', [UserController::class, 'destroyAssociacao'])->name('destroy.associacao.user');
            }
        );
        Route::prefix('/associar/colaborador')->group(
            function () {
                Route::get('/{id}', [ColaboradorController::class, 'createAssociar'])->name('create_associar');
                Route::put('/{id}', [ColaboradorController::class, 'updateAssociar'])->name('update_associar');
                Route::delete('/{id}', [ColaboradorController::class, 'destroyAssociacao'])->name('destroy.associacao.colaborador');
            }
        );
    }
);

Route::resource('/', LoginController::class);
Route::prefix('/login')->group(function () {
    Route::get('/auth-token', [LoginController::class, 'create_token']);
    Route::get('/esqueci-minha-senha', [LoginController::class, 'recuperarSenha']);
    Route::get('/recuperar-cartao-token', [LoginController::class, 'recuperarCartao']);
});

Route::get('/home', function () {
    return view('home'); //
});

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
