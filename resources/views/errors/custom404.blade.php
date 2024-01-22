@extends('layouts.app')

@section('titulo', "404 Página não encontrada")

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/">Home</a> 
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <h3>Você tentou acessar uma rota inesistente!</h3>
            </div>
        </div>
    </div>
@endsection
