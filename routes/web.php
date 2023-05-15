<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/administracao', function () {
    return view('administracao');
});

Route::get('/alarme', function () {
    return view('comercial.alarme');
});

Route::get('/rastreamento', function () {
    return view('comercial.rastreamento');
});

Route::get('portaria', function () {
    return view('comercial.portaria');
});

Route::get('/sac', function () {
    return view('rh.sac');
});

Route::get('/sesmt', function () {
    return view('rh.sesmt');
});

Route::get('/usuario', function () {
    return view('rh.usuario');
});

Route::get('/tecnica', function () {
    return view('tecnica');
});
