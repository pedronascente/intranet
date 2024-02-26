@extends('layouts.app')

@section('titulo', 'Meu Perfil')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-body box-profile">
            @if ($colaborador)
                <div class="text-center">
                    <img src="{{ asset('img/colaborador/' . $colaborador->foto . '') }}" alt="{{ $colaborador->nome }}"
                        width="70" class="rounded-circle">
                </div>
                <h3 class="profile-username text-center">{{ $usuario->name }}</h3>
                <p class="text-muted text-center">{{ $colaborador->cargo->nome }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Base</b> <a class="float-right">{{ $colaborador->base->nome }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Empresa</b> <a class="float-right">{{ $colaborador->empresa->nome }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Cargo</b> <a class="float-right">{{ $colaborador->cargo->nome }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Ramal</b> <a class="float-right">{{ $colaborador->ramal }}</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header">
            <h3 class="card-title"><b>Informações Pessoais</b></h3>
        </div>
        <div class="card-body">
            @if ($colaborador)
                Nome:
                <p class="text-muted">{{ $colaborador->nome }} {{ $colaborador->sobrenome }}</p> <hr>
                
                Email:
                <p class="text-muted"> {{ $colaborador->email }}</p><hr>
                
                RG:
                <p class="text-muted">{{ $colaborador->rg }}</p><hr>

                CPF:
                <p class="text-muted">{{ $colaborador->cpf }}</p> <hr>

                CNPJ:
                <p class="text-muted">{{ $colaborador->cnpj }}</p>
                
                <a href="{{ route('meuPerfil.edit', $colaborador->id) }}" class="btn bg-gradient-info">
                    Editar
                </a>
            @endif
        </div>
    </div>
    
    <div class="card p-3">
        <div class="card-header">
            <h3 class="card-title"><b>Segurança</b> </h3>
        </div>
        <div class="card-body">
            @if ($colaborador)
                @include('meuPerfil.resetPassword')
            @endif
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header">
            <h3 class="card-title"> <b>2FA - Tokens de Acesso</b> </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th class="text-center">Posição</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($usuario->tokens)
                        @foreach ($usuario->tokens as $token )
                            <tr class="text-center">
                                <td>{{$token->token}}</td>
                                <td>{{$token->posicao}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <hr>
        </div>
    </div>
@endsection