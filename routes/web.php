<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\LoginController;

Route::resource('/usuario', UsuarioController::class);
Route::resource('/empresa', EmpresaController::class);
Route::resource('/cargo', CargoController::class);
Route::resource('/perfil', GrupoController::class);
Route::resource('/modulo', ModuloController::class);
Route::resource('/colaborador', ColaboradorController::class);
Route::get('/perfil/desativar/{id}', [GrupoController::class, 'desativar']);

Route::resource('/', LoginController::class);

Route::get('/home', function () {
    return view('home');
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
