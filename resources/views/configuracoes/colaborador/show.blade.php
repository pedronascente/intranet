@extends('layouts.app')

@section('titulo', 'Colaborador | Visualizar')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/configuracoes/colaborador">colaborador</a>
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
        <h3 class="profile-username text-center">{{ $colaborador->nome . ' ' . $colaborador->sobrenome }}</h3>
        <p class="text-muted text-center">{{ $colaborador->cargo->nome }}</p>
        <table class="table table-md">
            <tr>
                <td colspan="1"><b>Ramal</b><br> {{ $colaborador->ramal }}</td>
                <td colspan="2"><b>Email</b><br> {{ $colaborador->email }}</td>
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
            @if ($colaborador->user)
                <tr>
                    <td colspan="3">
                        <b>Usuário </b><br>
                        {{ $colaborador->user->name }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>Perfil </b><br>
                        {{ $colaborador->user->perfil->nome }}
                    </td>
                </tr>
            @endif
        </table>
        <div class="card-footer">
            <a href="{{ route('colaborador.edit', $colaborador->id) }}" title="Editar" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <x-botao.btn-voltar :rota="route('colaborador.index')" />
        </div>
    </div>
@endsection
