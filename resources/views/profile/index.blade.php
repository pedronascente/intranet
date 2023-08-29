@extends('layouts.app')
@section('content')
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            @if ($colaborador)
                <div class="text-center">
                    <img src="{{ asset('img/colaborador/' . $colaborador->foto . '') }}" alt="{{ $colaborador->nome }}"
                        width="100" class="rounded-circle">
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
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Informações Pessoais</h3>
        </div>
        <div class="card-body">
            @if ($colaborador)
                <strong> Nome</strong>
                <p class="text-muted">{{ $colaborador->nome }} {{ $colaborador->sobrenome }}</p>
                <hr>
                <strong>Email</strong>
                <p class="text-muted"> {{ $colaborador->email }}</p>
                <hr>
                <strong>RG</strong>
                <p class="text-muted">{{ $colaborador->rg }}</p>
                <hr>
                <strong>CPF</strong>
                <p class="text-muted">{{ $colaborador->cpf }}</p>
                <hr>
                <strong>CNPJ</strong>
                <p class="text-muted">{{ $colaborador->cnpj }}</p>
                <a href="{{ route('user.edit.profile', $colaborador->id) }}" class="btn bg-gradient-primary">
                    Alterar Informaçoes
                </a>
            @endif
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Informações de Acesso</h3>
        </div>
        <div class="card-body">
            @if ($cartao)
                <strong> Cartão</strong>
                <p class="text-muted">{{ $cartao->nome }}</p>
                <hr>
                <table class="table table-bordered ">
                    <thead>
                        <th>Token</th>
                        <th class="text-center">Posição</th>
                    </thead>
                    <tbody>
                        @if ($cartao->tokens)
                            @foreach ($cartao->tokens as $item)
                                <tr>
                                    <td>{{ $item->token }}</td>
                                    <td class="text-center">{{ $item->posicao }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <hr>
            @endif
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Segurança</h3>
        </div>
        <div class="card-body">
            @if ($colaborador)
                @include('profile.resetPassword')
            @endif
        </div>
    </div>
@endsection
