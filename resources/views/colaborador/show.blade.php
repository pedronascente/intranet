@extends('layouts.app')
@section('content')
    <div class="card col-md-5">
        <div class="card-header  text-center">
            <h3><img src="https://assets.plugcrm.net/assets/2.0/dummy-round-352479a0a86fd5b4720729bcfa3e3834646e1b5a7a9d4d7c86ff789f67844718.png"
                    alt="" width="100"></h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-striped">
                <tbody>
                    <tr>
                        <td><b>NOME: </b> <br>{{ $colaborador->nome . ' ' . $colaborador->sobrenome }}</td>
                        <td><b>EMAIL: </b><br> {{ $colaborador->email }}</td>
                        <td></td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td><b>RG:</b> <br> {{ $colaborador->rg }}</td>
                        <td><b>CPF: </b> <br> {{ $colaborador->cpf }}</td>
                        <td><b>CNPJ: </b> <br> {{ $colaborador->cnpj }}</td>
                    </tr>
                    <tr>
                        <td><b>CARGO: </b> <br> {{ $colaborador->empresa->nome }}</td>
                        <td><b>EMPRESA: </b> <br> {{ $colaborador->cargo->nome }}</td>
                        <td></td>
                    </tr>
                </tbody>
                <tfooter>
                    <tr>
                        <td colspan="3">
                            <div class="btn-group ">
                                <a href="/colaborador/{{ $colaborador->id }}/edit" class="btn btn-default" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('colaborador.destroy', $colaborador->id) }}" method="post"
                                    title="Desativar">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <a href="/colaborador" class="btn btn-default" title="Voltar">
                                    <i class="fa fa-reply" aria-hidden="true"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tfooter>
            </table>
        </div>
    </div>
@endsection
