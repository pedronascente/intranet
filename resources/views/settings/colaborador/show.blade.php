@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <img src="{{ asset('img/colaborador/' . $colaborador->foto . '') }}" alt="{{ $colaborador->nome }}" width="100"
                class="rounded-circle">
        </div>
        <div class="card-body p-0">
            <table class="table table-md">
                <tr>
                    <td colspan="3"><b>Nome</b><br> {{ $colaborador->nome . ' ' . $colaborador->sobrenome }}</td>
                </tr>
                <tr>
                    <td colspan="3"><b>Email</b><br> {{ $colaborador->email }}</td>
                </tr>
                <tr>
                    <td><b>Rg</b> <br>{{ $colaborador->rg }}</td>
                    <td><b>Cpf </b> <br> {{ $colaborador->cpf }}</td>
                    <td><b>Cnpj </b> <br>{{ $colaborador->cnpj }}</td>
                </tr>
                <tr>
                    <td><b>Empresa</b><br>{{ $colaborador->empresa->nome }}</td>
                    <td colspan="2"><b>Cargo </b><br> {{ $colaborador->cargo->nome }}</td>
                </tr>
                @if ($colaborador->user)
                    <tr>
                        <td colspan="3">
                            <b>Usuário </b><br>
                            <a href="" class="btn btn-warning" title="Visualizar Usuário">
                                <i class="fas  fa-eye"></i> {{ $colaborador->user->name }}
                            </a>
                            <form action="{{ route('destroy.associacao.colaborador', $colaborador->id) }}" method="post"
                                style="display: inline;">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('destroy.associacao.colaborador', $colaborador->id) }}"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                    class="btn btn-danger" title="Remover usuário">
                                    <i class="fas fa-trash"></i> Remover
                                </a>
                            </form>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="3">
                            <b>Usuário </b><br>
                            <a href="{{ route('create_associar', $colaborador->id) }}" class="btn btn-primary"
                                title="Associar Usuário">
                                Associar Usuário
                            </a>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('colaborador.edit', $colaborador->id) }}" title="Editar" class="btn btn-primary">
                <i class="fas fa-edit"></i>
            </a>
            <a href="{{ route('colaborador.index') }}" title="Voltar" class="btn btn-danger">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </div>
@endsection
