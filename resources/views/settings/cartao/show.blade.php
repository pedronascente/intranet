@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">2FA | Visualizar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="/settings">Configurações</a> /
                            <a href="/settings/cartao">2FA</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-md ">
                <tr>
                    <td> <b> 2FA</b><br> {{ $cartao->nome }}</td>
                </tr>
                <tr>
                    <td><b>Status</b><br>
                        @if ($cartao->status == 'on')
                            ATIVO
                        @else
                            INATIVO
                        @endif
                    </td>
                </tr>
            </table>
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
            <table class="table table-md ">
                <tr>
                    <td><b>Usuário</b><br>
                        <a href="/settings/user/{{ $cartao->user->id }}" title="Visualizar Usuário" class="btn btn-warning">
                            <i class="fas  fa-eye"></i> {{ $cartao->user->name }}
                        </a>
                    </td>
                </tr>
            </table>
            <table class="table table-md">
                <tr>
                    <td>
                        <a href="{{ route('cartao.edit', $cartao->id) }}" title="Editar" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('cartao.index') }}" title="Voltar" class="btn btn-danger">
                            <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
