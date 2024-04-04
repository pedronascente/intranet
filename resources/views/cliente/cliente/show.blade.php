@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('cliente.index') }}">cliente</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Registrado com sucesso.</h5>
    </div>
    <div class="card p-3">    
        @include('cliente.cliente.dados_cliente')
        @include('cliente.contato.table')
        @include('cliente.socio.table')
        @include('cliente.endereco.table')
        @include('cliente.veiculo.table')
    </div>
@endsection
