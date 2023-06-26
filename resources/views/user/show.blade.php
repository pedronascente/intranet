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
                    <tr>
                        <td><b>Email: </b> {{ $user->email }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-md table-striped">
                <tr>
                    <td><b>COLABORADOR ASSOCIADO: </td>
                </tr>
            </table>

            @if ($user->colaborador)
                <table class="table table-md ">
                    <tbody>
                        <tr>
                            <td><b>Nome: </b> {{ $user->colaborador->nome }}</td>
                        </tr>
                        <tr>
                            <td><b>Cpf: </b> {{ $user->colaborador->cpf }}</td>
                        </tr>

                    </tbody>
                </table>
            @else
                <table class="table table-md ">
                    <tbody>
                        <tr>
                            <td><a href="/colaborador/{{ $user->id }}/edit" class="btn btn-md btn-success"
                                    title="Editar">
                                    <i class="fas fa-user"></i> Associar Colaborador
                                </a></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            <a href="/user" class="btn btn-warning" title="Voltar">
                <i class="fa fa-reply" aria-hidden="true"></i> Voltar
            </a>
            <a href="/user/{{ $user->id }}/edit" class="btn btn-primary" title="Editar">
                <i class="fas fa-pencil-alt"></i> Editar
            </a>
            <form action="{{ route('user.destroy', $user->id) }}" method="post" style="display: inline">
                @csrf()
                @method('DELETE')
                <button type="submit" class="btn btn-md btn-danger">
                    <i class="fas fa-times"></i> Excluir
                </button>
            </form>
        </div>
    </div>
@endsection
