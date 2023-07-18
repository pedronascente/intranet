<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\GrupoController;
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
        Route::resource('/perfil', GrupoController::class);
        Route::resource('/modulo', ModuloController::class);
        Route::resource('/cartao', CartaoController::class);
        Route::resource('/colaborador', ColaboradorController::class);
        Route::resource('/user', UserController::class);
        Route::get('/perfil/desativar/{id}', [GrupoController::class, 'desativar']);
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
Route::get('/token', [TokenController::class, 'create'])->name('token.create')->middleware('auth');
Route::post('/token', [TokenController::class, 'store'])->name('token.store')->middleware('auth');

/*
    Route::prefix('/login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        
        Route::get('/esqueci-minha-senha', [LoginController::class, 'recuperarSenha']);
        Route::get('/recuperar-cartao-token', [LoginController::class, 'recuperarCartao']);
    });
*/


Route::get('/home', [DashboardController::class, 'index'])->name('home.index')->middleware('auth');

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
