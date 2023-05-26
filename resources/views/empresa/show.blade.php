@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Detalhes</h3>
            </div>
            <div class="card-body">
                <div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nome</th>
                                <th style="width: 5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $empresa->id }}</td>
                                <td>{{ $empresa->nome }}</td>
                                <td>
                                    <div class="btn-group float-right">
                                        <a href="/empresa/{{ $empresa->id }}/edit" class="btn btn-default">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="/empresa/$empresa->id" method="post">
                                            @csrf()
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
