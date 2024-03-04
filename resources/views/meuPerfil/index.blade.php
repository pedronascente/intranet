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
                        width="100" class="rounded-circle">
                </div>
                <h3 class="profile-username text-center"><b>{{ $usuario->name }}</b></h3>
                <p class="text-muted text-center">{{ $colaborador->cargo->nome }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Base:</b> <br>{{ $colaborador->base->nome }}
                    </li>
                    <li class="list-group-item">
                        <b>Perfil:</b> <br>{{ $colaborador->usuario->perfil->nome }}
                    </li>
                    <li class="list-group-item">
                        <b>Empresa:</b> <br>{{ $colaborador->empresa->nome }}
                    </li>
                    <li class="list-group-item">
                        <b>Cargo:</b> <br>{{ $colaborador->cargo->nome }}
                    </li>
                    <li class="list-group-item">
                        <b>Ramal:</b> <br>{{ $colaborador->ramal }}
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
                <b>Nome:</b>
                <p class="text-muted">{{ $colaborador->nome }}</p> <hr>
                
                <b>Email:</b>
                <p class="text-muted"> {{ $colaborador->email }}</p><hr>
                
                <b>RG:</b>
                <p class="text-muted">{{ $colaborador->rg }}</p><hr>

                <b>CPF:</b>
                <p class="text-muted">{{ $colaborador->cpf }}</p> <hr>

                @if ($colaborador->cnpj)
                    <b>CNPJ:</b>
                    <p class="text-muted">{{ $colaborador->cnpj }}</p>
                    
                @endif
                
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