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
                    <td><b>Nome :</b> {{ $empresa->nome }}</td>
                </tr>
                <tr>
                    <td><b>CNPJ :</b> {{ $empresa->cnpj }}</td>
                </tr>
            </table>
            @if ($empresa->colaboradores->count() >= 1)
                <table class="table table-md table-striped">
                    <tr>
                        <td><b>COLABORADOR(ES): </td>
                    </tr>
                </table>
                <table class="table table-md ">
                    <tbody>
                        @foreach ($empresa->colaboradores as $colaborador)
                            <tr>
                                <td>{{ $colaborador->nome }}</td>
                                <td>
                                    <a href="/colaborador/{{ $colaborador->id }}" class="btn  btn-md btn-warning"
                                        title="Visualizar">
                                        <i class="fas fa-solid fa-eye  "></i> Visualizar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <table class="table table-md">
                <tr>
                    <td>
                        <a href="/empresa" class="btn  btn-md btn-default" title="Voltar">
                            <i class="fa fa-reply" aria-hidden="true"></i> Voltar
                        </a>
                        <a href="/empresa/{{ $empresa->id }}/edit" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/empresa/{{ $empresa->id }}" method="post" style="display: inline">
                            @csrf()
                            @method('DELETE')
                            <button type="submit" class="btn btn-md btn-danger">
                                <i class="fas fa-trash"></i> Deletar
                            </button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
