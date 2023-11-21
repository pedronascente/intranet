@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha.index') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <div class="card-body table-responsive p-0">
                @include('comissao.table.' . $formulario)
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-body table-responsive p-0">
                <h4>Cadastrar Comissão</h4>
                @include('comissao.formulario.create.' . $formulario)
            </div>
        </div>
    </div>
@endsection
