@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Usuário | Visualizar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/configuracoes">Configurações</a> /
                            <a href="/configuracoes/user">usuário</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">

                @if ($user->colaborador)
                    <img src="{{ asset('img/colaborador/' . $user->colaborador->foto . '') }}"
                        alt="{{ $user->colaborador->nome }}" width="100" class="rounded-circle">
                @else
                    <img src="{{ asset('img/colaborador/dummy-round.png') }}" alt="dummy-round.png" width="100"
                        class="rounded-circle">
                @endif
            </div>
            <h3 class="profile-username text-center">{{ $user->name }}</h3>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Perfil</b> <a class="float-right"> {{ $user->perfil->nome }}</a>
                </li>
                <li class="list-group-item">
                    <b>Status</b> <a class="float-right"> {{ $status }}</a>
                </li>
                <li class="list-group-item">
                    <b>2FA</b>
                    @if ($user->cartao)
                        <a class="float-right btn btn-warning" href="{{ route('cartao.show', $user->cartao->id) }}"
                            title="visualizar" class="btn btn-warning">
                            <i class="fas  fa-eye"></i> {{ $user->cartao->nome }}
                        </a>
                    @else
                        <a class="float-right btn btn-success" href="{{ route('cartao.registar', $user->id) }}"
                            class="btn btn-info" title="2FA">
                            Registrar 2FA
                        </a>
                    @endif
                </li>
            </ul>
        </div>

        <div class="card-footer">
            <a href="{{ route('user.edit', $user->id) }}" title="Editar" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('user.index') }}" title="Voltar" class="btn btn-danger">
                <i class="fa fa-reply" aria-hidden="true"></i> Voltar
            </a>
        </div>
    </div>
@endsection
