@extends('layouts.app')
@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Detalhes</h3>
        </div>
        <div class="card-body">
            <div>
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
                </table>
            </div>
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
