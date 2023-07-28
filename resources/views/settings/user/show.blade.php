@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            @if ($user->colaborador)
                <img src="{{ asset('img/colaborador/' . $user->colaborador->foto . '') }}"
                    alt="{{ $user->colaborador->nome }}" width="100" class="rounded-circle">
            @else
                <img src="{{ asset('img/colaborador/dummy-round.png') }}" alt="dummy-round.png" width="100"
                    class="rounded-circle">
            @endif
        </div>
        <div class="card-body p-0">
            <table class="table table-md">
                <tbody>
                    <tr>
                        <td width="90%"> <b>Usuário:</b><br> {{ $user->name }}</td>
                        <td><b>Status : </b><br>
                            @if ($user->status == 'on')
                                Ativo
                            @else
                                Inativo
                            @endif
                        </td>
                    </tr>
                    @if ($user->colaborador)
                        <tr>
                            <td>
                                <b>Colaborador:</b><br>
                                <a href="{{ route('colaborador.show', $user->colaborador->id) }}" title="Visualizar">
                                    {{ $user->colaborador->nome }}
                                    {{ $user->colaborador->sobrenome }}
                                </a>
                            </td>
                            <td>
                                <b>Opções:</b> <br>
                                <form action="{{ route('destroy.associacao.user', $user->colaborador->id) }}" method="post"
                                    style="display: inline;">
                                    @method('DELETE')
                                    @csrf
                                    <a href="{{ route('destroy.associacao.user', $user->colaborador->id) }}"
                                        onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                        class="btn btn-danger">
                                        Remover
                                    </a>
                                </form>
                            </td>
                        <tr>
                        @else
                        <tr>
                            <td colspan="2">
                                <a href="{{ route('user.associar', $user->id) }}" class="btn btn-info"
                                    title="Associar usuário">
                                    Associar Colaborador
                                </a>
                            </td>
                        </tr>
                    @endif
                    @if ($user->cartao)
                        <tr>
                            <td>
                                <b>Cartão:</b><br>
                                <a href="{{ route('cartao.show', $user->cartao->id) }}" title="visualizar cartão"
                                    style="padding-right: 10px">
                                    {{ $user->cartao->nome }}
                                </a>
                            </td>
                            <td width="10%"><b>Status:</b> <br>
                                @if ($user->cartao->status == 'on')
                                    Ativo
                                @else
                                    Inativo
                                @endif
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2">
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p>
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        Usuário não possui cartão Token.
                                    </p>
                                </div>
                                <a href="{{ route('cartao.registar', $user->id) }}" class="btn btn-info"
                                    title="Criar Cartão">
                                    Registrar Cartão Token
                                </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('user.edit', $user->id) }}" title="Editar">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('user.destroy', $user->id) }}" method="post"
                style="display: inline;style="padding-right: 10px"" title="Excluir">
                @method('DELETE')
                @csrf
                <a href="{{ route('user.destroy', $user->id) }}"
                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                    <i class="fas fa-trash"></i>
                </a>
            </form>
            <a href="{{ route('user.index') }}" title="Voltar" style="padding-right: 10px">
                <i class="fa fa-reply" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection
