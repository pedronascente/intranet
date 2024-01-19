@extends('layouts.app')

@section('titulo', $planilha->tipo->nome)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('comissao.administrativo.index') }}">Planilha</a>
        </li>
    </ol>
@endsection
 
@section('content')

<div class="card p-3">    
    <div class="card">
        <div class="card-header">
            <h4>Dados do colaborador</h4>
        </div>
        <div class="card-body table-responsive p-0">
            @include('planilha.tipo._table-dados-colaborador')
        </div>
    </div>
</div>    

<div class="card p-3">    
    <div class="card">
        <div class="card-header">
            <x-filtro-form-comissao :route="route('comissao.administrativo-tipo.index', $planilha->id)" />
        </div>
        <div class="card-body table-responsive p-0">
            @include('planilha.tipo.comercialAlarmeCercaEletricaCFTV.administrativo.table')
        </div>
        <div class="card-footer">
            <x-botao.btns-crud-planilha-administrativo :planilha="$planilha" />
        </div>
    </div>
</div>    
@endsection