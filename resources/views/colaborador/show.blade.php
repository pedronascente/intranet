@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            <img src="{{ asset('img/colaborador/' . $colaborador->foto . '') }}" alt="{{ $colaborador->nome }}" width="100"
                class="rounded-circle">
        </div>
        <div class="card-body p-0">
            <table class="table table-md table-striped">
                <tr>
                    <td><b>DADOS: </td>
                </tr>
            </table>
            <table class="table table-md ">
                <tbody>
                    <tr>
                        <td><b>Nome: </b> {{ $colaborador->nome . ' ' . $colaborador->sobrenome }}</td>
                    </tr>
                    <tr>
                        <td><b>Email: </b> {{ $colaborador->email }}</td>
                    </tr>
                    <tr>
                        <td><b>Rg:</b> {{ $colaborador->rg }}</td>
                    </tr>
                    <tr>
                        <td><b>Cpf: </b> {{ $colaborador->cpf }}</td>
                    </tr>
                    <tr>
                        <td><b>Cnpj: </b> {{ $colaborador->cnpj }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-md table-striped">
                <tr>
                    <td><b>EMPRESA: </td>
                </tr>
            </table>
            <table class="table table-md ">
                <tbody>
                    <tr>
                        <td><b>Nome: </b> {{ $colaborador->empresa->nome }}</td>
                    </tr>
                    <tr>
                        <td><b>Cargo: </b> {{ $colaborador->cargo->nome }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-md table-striped">
                <tr>
                    <td><b>USUÁRIO: </td>
                </tr>
            </table>
            @if ($colaborador->user)
                <table class="table table-md ">
                    <tbody>
                        <tr>
                            <td><b>Status: </b> {{ $colaborador->user->ativo }}</td>
                        </tr>
                        <tr>
                            <td><b>Nome: </b> {{ $colaborador->user->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email: </b> {{ $colaborador->user->email }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <table class="table table-md ">
                    <tbody>
                        <tr>
                            <td><a href="/colaborador/{{ $colaborador->id }}/edit" class="btn btn-md btn-success"
                                    title="Editar">
                                    <i class="fas fa-user"></i> Associar Usuário
                                </a></td>
                        </tr>
                    </tbody>
                </table>
            @endif
            <table class="table table-md">
                <tbody>
                    <tr>
                        <td>
                            <a href="/colaborador" class="btn btn-md btn-default" title="Voltar">
                                <i class="fa fa-reply"></i> Voltar
                            </a>
                            <a href="/colaborador/{{ $colaborador->id }}/edit" class="btn btn-md btn-primary"
                                title="Editar">
                                <i class="fas fa-pencil-alt"></i> Editar
                            </a>
                            <form action="/colaborador/{{ $colaborador->id }}" method="post" style="display: inline">
                                @csrf()
                                @method('DELETE')
                                <button type="submit" class="btn btn-md btn-danger">
                                    <i class="fas fa-times"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
