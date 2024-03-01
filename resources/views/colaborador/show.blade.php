@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="{{ route('colaborador.index') }}">colaborador</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="text-center">
            <img src="{{ asset('img/colaborador/' . $colaborador->foto . '') }}" 
                alt="{{ $colaborador->nome }}"
                width="100" class="rounded-circle">
        </div>
        <h3 class="profile-username text-center">{{ $colaborador->nome }}</h3>
        <p class="text-muted text-center">{{ $colaborador->cargo->nome }}</p>
        <table class="table table-md">
            <tr>
                <td><b>Ramal</b><br> {{ $colaborador->ramal }}</td>
                <td><b>Email</b><br> {{ $colaborador->email }}</td>
                <td><b>Matricula</b><br> {{ $colaborador->numero_matricula }}</td>
            </tr>
            <tr>
                <td><b>Rg</b> <br>{{ $colaborador->rg }}</td>
                <td><b>Cpf </b> <br> {{ $colaborador->cpf }}</td>
                <td><b>Cnpj </b> <br>{{ $colaborador->cnpj }}</td>
            </tr>
            <tr>
                <td><b>Base</b><br>{{ $colaborador->base->nome }}</td>
                <td><b>Empresa</b><br>{{ $colaborador->empresa->nome }}</td>
                <td><b>Cargo </b><br> {{ $colaborador->cargo->nome }}</td>
            </tr>
            @if ($colaborador->usuario)
                <tr>
                    <td colspan="3">
                        <b>Usuário </b><br>
                        {{ $colaborador->usuario->name }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>Perfil </b><br>
                        {{ $colaborador->usuario->perfil->nome }}
                    </td>
                </tr>
            @endif
        </table>
        <div class="card-footer">
            <x-botao.btn-editar :rota="route('colaborador.edit', $colaborador->id)"  :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota"/>
            <x-botao.btn-voltar :rota="route('colaborador.index')" />
        </div>
    </div>
@endsection