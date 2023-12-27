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
        <div class="card-header">
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
            @include('planilha.tipo.reclamacaoDeCliente.administrativo.table')
        </div>
        <div class="card-footer">
             <x-btns-visualizar-planilha-administrativo :planilha="$planilha" />
        </div>
    </div>
@endsection
