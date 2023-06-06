@extends('layouts.app')
@section('content')
    <div class="card col-md-12">
        <div class="card-header  ">
            <img src="{{ asset('img/colaborador/' . $colaborador->foto . '') }}" alt="{{ $colaborador->nome }}" width="100"
                class="rounded-circle">
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-striped">
                <tbody>
                    <tr>
                        <td><b>Nome: </b> {{ $colaborador->nome . ' ' . $colaborador->sobrenome }}</td>
                        <td><b>Email: </b> {{ $colaborador->email }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>Rg:</b> {{ $colaborador->rg }}</td>
                        <td><b>Cpf: </b> {{ $colaborador->cpf }}</td>
                        <td><b>Cnpj: </b> {{ $colaborador->cnpj }}</td>
                    </tr>
                    <tr>
                        <td><b>Cargo: </b> {{ $colaborador->empresa->nome }}</td>
                        <td><b>Empresa: </b> {{ $colaborador->cargo->nome }}</td>
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
