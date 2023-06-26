<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\LoginController;
use \App\Http\Controllers\Auth\RegisteredUserController;

Route::resource('/colaborador', ColaboradorController::class);
Route::resource('/empresa', EmpresaController::class);
Route::resource('/cargo', CargoController::class);
Route::resource('/permissao', PermissaoController::class);
Route::resource('/perfil', GrupoController::class);

Route::prefix('/user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('user.register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('user.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/destroy', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::resource('/modulo', ModuloController::class);
Route::get('/perfil/desativar/{id}', [GrupoController::class, 'desativar']);
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
