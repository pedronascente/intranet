@extends('layouts.app')
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Detalhes</h3>
        </div>
        <div class="card-body">

            <table class="table table-sm">
                <tbody>
                    <tr>
                        <td colspan="2"><b>ID :</b> {{ $empresa->id }}</td>
                    </tr>
                    <tr>
                        <td><b>Nome :</b> {{ $empresa->nome }}</td>
                    </tr>
                    <tr>
                        <td><b>CNPJ :</b> {{ $empresa->cnpj }}</td>
                    </tr>
                </tbody>
                @if ($empresa->colaboradores->count() >= 1)
                    <tfooter>
                        <tr>
                            <td>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Colaboradores</th>
                                            <th style="width: 40px">Visualizar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($empresa->colaboradores as $colaborador)
                                            <tr>
                                                <td>{{ $colaborador->nome }}</td>
                                                <td>
                                                    <a href="/colaborador/{{ $colaborador->id }}"
                                                        class="btn  btn-xs btn-default" title="Visualizar">
                                                        <i class="fas fa-solid fa-eye  "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tfooter>
                @endif
            </table>
        </div>
        <div class="card-footer">
            <div class="btn-group ">
                <a href="/empresa/{{ $empresa->id }}/edit" class="btn btn-sm btn-default">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <form action="/empresa/{{ $empresa->id }}" method="post">
                    @csrf()
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-default">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
                <a href="/empresa" class="btn  btn-sm btn-default" title="Voltar">
                    <i class="fa fa-reply" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
