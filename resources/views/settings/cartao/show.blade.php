@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-md table-striped">
                <tr>
                    <td><b>DADOS:</td>
                </tr>
            </table>
            <table class="table table-md">
                <tr>
                    <td> <b> Cartão :</b> {{ $cartao->nome }}</td>
                    <td class="text-right"><b>Status :</b>
                        @if ($cartao->status == 'on')
                            ATIVO
                        @else
                            INATIVO
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>Usuário :</b>
                        <a href="/settings/user/{{ $cartao->user->id }}" title="Visualizar" style="padding-right: 10px">
                            {{ $cartao->user->name }}
                        </a>
                    </td>
                </tr>
                <table class="table table-bordered ">
                    <thead>
                        <th width="10%">Token</th>
                        <th width="10%" class="text-center">Posição</th>
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
                <table class="table table-md">
                    <tr>
                        <td>
                            <a href="{{ route('cartao.index') }}" title="Voltar" style="padding-right: 10px">
                                <i class="fa fa-reply" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('cartao.edit', $cartao->id) }}" title="Editar" style="padding-right: 10px">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('cartao.destroy', $cartao->id) }}" method="post"
                                style="display: inline ;" title="Excluir">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('cartao.destroy', $cartao->id) }}"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </form>
                            <a href="{{ route('cartao.edit', $cartao->id) }}" title="Voltar" style="padding-right: 10px">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
@endsection
