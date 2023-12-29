@extends('layouts.app')

@section('titulo', $planilha->tipo->nome)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('planilha-colaborador.index') }}">Planilha</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-header">
            <h4>Cadastrar comissão</h4>
        </div>
        <div class="card-body table-responsive p-0">
            @include('planilha.tipo.supervisaoTecnicaESACAlarmesCercaEletricaCFTV.create')
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header">
            <h4>Lista de Comissões</h4>
        </div>
        <div class="card-body table-responsive p-0">
            @include('planilha.tipo.supervisaoTecnicaESACAlarmesCercaEletricaCFTV.colaborador.table')
            <x-ui.modalDelete />
        </div>
    </div>
@endsection
