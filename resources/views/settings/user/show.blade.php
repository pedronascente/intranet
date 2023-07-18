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
            <table class="table table-md table-striped">
                <tr>
                    <td><b>DADOS: </td>
                </tr>
            </table>
            <table class="table table-md">
                <tbody>
                    <tr>
                        <td><b>Status : </b>
                            @if ($user->ativo == 'on')
                                Ativo
                            @else
                                Inativo
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Usuário:</b> {{ $user->name }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-md table-striped">
                <tr>
                    <td><b>COLABORADOR: </td>
                </tr>
            </table>

            @if ($user->colaborador)
                <table class="table table-md ">
                    <tbody>
                        <tr>
                            <td><b>Nome: </b> {{ $user->colaborador->nome }} {{ $user->colaborador->sobrenome }}</td>

                            <td><b>Cpf: </b> {{ $user->colaborador->cpf }}</td>

                            <td class="text-right">
                                <form action="{{ route('destroy.associacao.user', $user->colaborador->id) }}" method="post"
                                    style="display: inline;" title="Excluir">
                                    @method('DELETE')
                                    @csrf
                                    <a href="{{ route('destroy.associacao.user', $user->colaborador->id) }}"
                                        onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                        style="color:red">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </form>
                            </td>
                    </tbody>
                </table>
            @else
                <table class="table table-md ">
                    <tbody>
                        <tr>
                            <td>
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <p> <i class="icon fas fa-exclamation-triangle"></i>
                                        Nenhuma associação foi encontrado!</p>
                                </div>
                                <a href="{{ route('user.associar', $user->id) }}" class="btn btn-info"
                                    title="Associar usuário">
                                    Associar
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('user.index') }}" title="Voltar" style="padding-right: 10px">
                <i class="fa fa-reply" aria-hidden="true"></i>
            </a>
            <a href="{{ route('user.edit', $user->id) }}" title="Editar" style="padding-right: 10px">
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
        </div>
    </div>
@endsection
