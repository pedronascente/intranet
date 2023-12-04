@extends('layouts.app')

@section('titulo', $planilha->tipo->nome)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha.index') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-body table-responsive p-0">
            @include('comissao.table.' . $planilha->tipo->formulario)
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Cadastrar Comissão</h4>
        </div>
        <div class="card-body table-responsive p-0">
            @include('comissao.formulario.create.' . $planilha->tipo->formulario)
        </div>
    </div>
@endsection
