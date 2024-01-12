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
        <div class="card">
            <div class="card-header">
                <h4>Cadastrar comissão</h4>
            </div>
            <div class="card-body table-responsive p-0">
                @include('planilha.tipo.supervisaoComercialRastreamento.create')
            </div>
        </div>
    </div>
    <div class="card p-3">
        <div class="card">
            <div class="card-header">
                <h4>Lista de Comissões</h4>
            </div>
            <div class="card-body table-responsive p-0">
                @include('planilha.tipo.supervisaoComercialRastreamento.colaborador.table')
                <x-ui.modalDelete />
            </div>
        </div>
    </div>
@endsection
