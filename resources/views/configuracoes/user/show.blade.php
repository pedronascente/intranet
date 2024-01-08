@extends('layouts.app')

@section('titulo', 'Usuário | Visualizar')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="/configuracoes/user">usuário</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-body box-profile">
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Nome</b> <a class="float-right"> {{ $user->name }}</a>
                </li>
                <li class="list-group-item">
                    <b>Perfil</b> <a class="float-right"> {{ $user->perfil->nome }}</a>
                </li>
                <li class="list-group-item">
                    <b>Status</b> <a class="float-right"> {{ $status }}</a>
                </li>
                <li class="list-group-item">
                    <b>QTD. de Tokens:</b> <a class="float-right"> {{ $user->qtdToken }}</a>
                </li>
            </ul>
        </div>
        <div class="card-footer">
            <a href="{{ route('user.edit', $user->id) }}" title="Editar" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('user.index') }}" title="Voltar" class="btn btn-sm btn-danger">
                <i class="fa fa-reply" aria-hidden="true"></i> Voltar
            </a>
        </div>
    </div>
@endsection
