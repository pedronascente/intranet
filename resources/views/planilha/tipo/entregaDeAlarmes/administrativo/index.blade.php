@extends('layouts.app')

@section('titulo', $planilha->tipo->nome)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha-administrativo.index') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header  ">
            <h4>Dados do colaborador</h4>
        </div>
        <div class="card-body table-responsive p-0">
            @include('planilha.tipo._table-dados-colaborador')
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Comissões</h4>
        </div>
        <div class="card-body table-responsive p-0">
            @include('planilha.tipo.entregaDeAlarmes.administrativo.table')
        </div>
        <div class="card-footer">
            <a href="" class="btn btn-success btn-sm" title="Editar comissão">
                <i class="nav-icon fas fa-print"></i> Imprimir
            </a>
            <a href="{{ route('planilha-administrativo.index') }}" class="btn btn-danger btn-sm" title="Voltar">
                <i class="fa fa-reply"></i> Voltar
            </a>
        </div>
    </div>
@endsection
