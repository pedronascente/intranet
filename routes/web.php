<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\GrupoController;

Route::resource('/empresa', EmpresaController::class);
Route::resource('/usuario', UsuarioController::class);
Route::resource('/colaborador', ColaboradorController::class);
Route::resource('/perfil', GrupoController::class);

Route::get('/perfil/desativar/{id}', [GrupoController::class, 'desativar']);

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
