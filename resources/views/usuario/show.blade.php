@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/configuracoes">Configurações</a> /
            <a href="{{ route('usuario.index') }}">usuário</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card-body box-profile">
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item"> <b>Nome:</b> <br>{{ $usuario->name }}</li>
                <li class="list-group-item"> <b>Perfil:</b> <br>{{ $usuario->perfil->nome }} </li>
                <li class="list-group-item"> <b>Status:</b> <br>{{ $status }}</li>
                <li class="list-group-item"> <b>QTD. de Tokens:</b> <br> {{ $usuario->qtdToken }}</li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> <b> Tokens </b> </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
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
        <div class="card-footer">
            <x-botao.btn-editar :rota="route('usuario.edit', $usuario->id)" :arrayListPermissoesDoModuloDaRota="$arrayListPermissoesDoModuloDaRota"/>
            <x-botao.btn-voltar :rota="route('usuario.index')" />
        </div>
    </div>
    @endsection
