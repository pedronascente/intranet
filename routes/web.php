<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TipoController;

Route::resource('/usuario', UsuarioController::class);
Route::resource('/empresa', EmpresaController::class);
Route::resource('/cargo', TipoController::class);
Route::resource('/perfil', GrupoController::class);
Route::resource('/modulo', ModuloController::class);
Route::get('/perfil/desativar/{id}', [GrupoController::class, 'desativar']);

Route::get('/', function () {
    return view('login');
});


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
