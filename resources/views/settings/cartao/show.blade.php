@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-md ">
                <tr>
                    <td> <b> Cartão</b><br> {{ $cartao->nome }}</td>
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
                    <td><b>Dono do Cartão</b><br>
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
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('cartao.index') }}" title="Voltar" class="btn btn-danger">
                            <i class="fa fa-reply" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
