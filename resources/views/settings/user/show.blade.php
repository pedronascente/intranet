@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            @if ($user->colaborador)
                <img src="{{ asset('img/colaborador/' . $user->colaborador->foto . '') }}"
                    alt="{{ $user->colaborador->nome }}" width="90" class="rounded-circle">
            @else
                <img src="{{ asset('img/colaborador/dummy-round.png') }}" alt="dummy-round.png" width="100"
                    class="rounded-circle">
            @endif
        </div>
        <div class="card-body p-0">
            <table class="table table-md">
                <tbody>
                    <tr>
                        <td> <b>Usuário</b><br> {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Perfil</b><br>
                            {{ $user->perfil->nome }}
                        </td>
                    </tr>
                    <tr>
                        <td><b>Status </b><br>
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
                                <b>Colaborador</b><br>

                                <a href="{{ route('colaborador.show', $user->colaborador->id) }}"
                                    title="Visualizar Colaborador" class="btn btn-warning">
                                    <i class="fas  fa-eye"></i>
                                    {{ $user->colaborador->nome }}
                                    {{ $user->colaborador->sobrenome }}
                                </a>

                                <form action="{{ route('destroy.associacao.user', $user->colaborador->id) }}" method="post"
                                    style="display: inline;">
                                    @method('DELETE')
                                    @csrf
                                    <a href="{{ route('destroy.associacao.user', $user->colaborador->id) }}"
                                        onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                        class="btn btn-danger" title="Remover Colaborador">
                                        <i class="fas fa-trash"></i> Remover
                                    </a>
                                </form>
                            </td>
                        <tr>
                        @else
                        <tr>
                            <td>
                                <b>Colaborador</b><br>
                                <a href="{{ route('user.associar', $user->id) }}" class="btn btn-primary"
                                    title="Associar usuário">
                                    Associar Colaborador
                                </a>
                            </td>
                        </tr>
                    @endif
                    @if ($user->cartao)
                        <tr>
                            <td>
                                <b>Cartão</b><br>
                                <a href="{{ route('cartao.show', $user->cartao->id) }}" title="visualizar cartão"
                                    class="btn btn-warning">
                                    <i class="fas  fa-eye"></i> {{ $user->cartao->nome }}
                                </a>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2">
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
            <a href="{{ route('user.edit', $user->id) }}" title="Editar" class="btn btn-primary">
                <i class="fas fa-edit"></i>
            </a>
            <a href="{{ route('user.index') }}" title="Voltar" class="btn btn-danger">
                <i class="fa fa-reply" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection
